<?php
// Add at the very top of the file, before any output
ini_set('memory_limit', '256M');
ini_set('max_execution_time', 300);

require 'header.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require '../config/conn.php';

// Get date range from request
$dateFrom = isset($_GET['date_from']) ? $_GET['date_from'] : date('Y-m-01'); // Default to first day of current month
$dateTo = isset($_GET['date_to']) ? $_GET['date_to'] : date('Y-m-d'); // Default to today

// Format dates for SQL
$sqlDateFrom = date('Y-m-d 00:00:00', strtotime($dateFrom));
$sqlDateTo = date('Y-m-d 23:59:59', strtotime($dateTo));

// Get total orders
$totalOrdersQuery = "SELECT COUNT(*) as total FROM DonHang WHERE ngayTaoDon BETWEEN ? AND ? AND id_trangThai != (SELECT id_trangThai FROM TrangThai WHERE tenTrangThai = 'Đã hủy')";
$stmt = $mysqli->prepare($totalOrdersQuery);
$stmt->bind_param("ss", $sqlDateFrom, $sqlDateTo);
$stmt->execute();
$totalOrders = $stmt->get_result()->fetch_assoc()['total'];

// Get total revenue
$revenueQuery = "SELECT 
    SUM(f.tongPhi) as totalRevenue,
    SUM(f.phiDichVu) as totalServiceFee,
    SUM(f.phiKhaiGia) as totalDeclaredValueFee,
    SUM(o.COD) as totalCOD
FROM DonHang o
JOIN phi f ON o.id_phi = f.id_phi
WHERE o.ngayTaoDon BETWEEN ? AND ? 
AND o.id_trangThai != (SELECT id_trangThai FROM TrangThai WHERE tenTrangThai = 'Đã hủy')";
$stmt = $mysqli->prepare($revenueQuery);
$stmt->bind_param("ss", $sqlDateFrom, $sqlDateTo);
$stmt->execute();
$revenue = $stmt->get_result()->fetch_assoc();

// Get orders by status
$statusQuery = "SELECT 
    t.tenTrangThai,
    COUNT(*) as count
FROM DonHang o
JOIN TrangThai t ON o.id_trangThai = t.id_trangThai
WHERE o.ngayTaoDon BETWEEN ? AND ?
GROUP BY t.id_trangThai, t.tenTrangThai";
$stmt = $mysqli->prepare($statusQuery);
$stmt->bind_param("ss", $sqlDateFrom, $sqlDateTo);
$stmt->execute();
$statusStats = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Get daily revenue for chart
$dailyRevenueQuery = "SELECT 
    DATE(ngayTaoDon) as date,
    SUM(f.tongPhi) as revenue
FROM DonHang o
JOIN phi f ON o.id_phi = f.id_phi
WHERE ngayTaoDon BETWEEN ? AND ?
AND o.id_trangThai != (SELECT id_trangThai FROM TrangThai WHERE tenTrangThai = 'Đã hủy')
GROUP BY DATE(ngayTaoDon)
ORDER BY date";
$stmt = $mysqli->prepare($dailyRevenueQuery);
$stmt->bind_param("ss", $sqlDateFrom, $sqlDateTo);
$stmt->execute();
$dailyRevenue = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Handle Excel export
if (isset($_GET['export']) && $_GET['export'] === 'excel') {
    try {
        require __DIR__ . '/../vendor/autoload.php';

        // Create new Spreadsheet object
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set document properties
        $spreadsheet->getProperties()
            ->setCreator('WebGiaoHang')
            ->setLastModifiedBy('WebGiaoHang')
            ->setTitle('Báo cáo doanh thu')
            ->setSubject('Báo cáo doanh thu từ ' . date('d/m/Y', strtotime($dateFrom)) . ' đến ' . date('d/m/Y', strtotime($dateTo)));

        // Set headers with styling
        $sheet->setCellValue('A1', 'Báo cáo doanh thu từ ' . date('d/m/Y', strtotime($dateFrom)) . ' đến ' . date('d/m/Y', strtotime($dateTo)));
        $sheet->mergeCells('A1:B1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Add summary data with styling
        $summaryData = [
            ['Tổng số đơn hàng', $totalOrders],
            ['Tổng doanh thu', number_format($revenue['totalRevenue'] ?? 0, 0, ',', '.') . ' VNĐ'],
            ['Phí dịch vụ', number_format($revenue['totalServiceFee'] ?? 0, 0, ',', '.') . ' VNĐ'],
            ['Phí khai giá', number_format($revenue['totalDeclaredValueFee'] ?? 0, 0, ',', '.') . ' VNĐ'],
            ['Tổng COD', number_format($revenue['totalCOD'] ?? 0, 0, ',', '.') . ' VNĐ']
        ];

        $row = 3;
        foreach ($summaryData as $data) {
            $sheet->setCellValue('A' . $row, $data[0]);
            $sheet->setCellValue('B' . $row, $data[1]);
            $row++;
        }

        // Add status statistics with styling
        $sheet->setCellValue('A' . ($row + 1), 'Thống kê theo trạng thái');
        $sheet->mergeCells('A' . ($row + 1) . ':B' . ($row + 1));
        $sheet->getStyle('A' . ($row + 1))->getFont()->setBold(true);
        $sheet->getStyle('A' . ($row + 1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A' . ($row + 2), 'Trạng thái');
        $sheet->setCellValue('B' . ($row + 2), 'Số lượng');
        $sheet->getStyle('A' . ($row + 2) . ':B' . ($row + 2))->getFont()->setBold(true);

        $row += 3;
        foreach ($statusStats as $stat) {
            $sheet->setCellValue('A' . $row, $stat['tenTrangThai']);
            $sheet->setCellValue('B' . $row, $stat['count']);
            $row++;
        }

        // Add daily revenue with styling
        $sheet->setCellValue('A' . ($row + 1), 'Doanh thu theo ngày');
        $sheet->mergeCells('A' . ($row + 1) . ':B' . ($row + 1));
        $sheet->getStyle('A' . ($row + 1))->getFont()->setBold(true);
        $sheet->getStyle('A' . ($row + 1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        $sheet->setCellValue('A' . ($row + 2), 'Ngày');
        $sheet->setCellValue('B' . ($row + 2), 'Doanh thu');
        $sheet->getStyle('A' . ($row + 2) . ':B' . ($row + 2))->getFont()->setBold(true);

        $row += 3;
        foreach ($dailyRevenue as $daily) {
            $sheet->setCellValue('A' . $row, date('d/m/Y', strtotime($daily['date'])));
            $sheet->setCellValue('B' . $row, number_format($daily['revenue'], 0, ',', '.') . ' VNĐ');
            $row++;
        }

        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(30);
        $sheet->getColumnDimension('B')->setWidth(20);

        // Add borders to all cells with data
        $lastRow = $row - 1;
        $sheet->getStyle('A1:B' . $lastRow)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        // Create Excel file
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = 'Bao_cao_doanh_thu_' . date('Y-m-d') . '.xlsx';
        
        // Clear any previous output
        if (ob_get_length()) ob_clean();
        
        // Set headers for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        
        // Save to temporary file first
        $tempFile = tempnam(sys_get_temp_dir(), 'excel_');
        $writer->save($tempFile);
        
        // Get file size
        $filesize = filesize($tempFile);
        header('Content-Length: ' . $filesize);
        
        // Output file contents
        readfile($tempFile);
        
        // Clean up
        unlink($tempFile);
        exit;
    } catch (Exception $e) {
        // Log the error
        error_log('Excel export error: ' . $e->getMessage());
        die('Có lỗi xảy ra khi xuất file Excel. Vui lòng thử lại sau.');
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Báo cáo doanh thu</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./css/orders.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .report-container {
            background: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .stat-card {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
        }
        .stat-card h4 {
            color: #666;
            margin: 0 0 10px 0;
            font-size: 14px;
        }
        .stat-card .value {
            font-size: 24px;
            font-weight: bold;
            color: #0dcaf0;
        }
        .chart-container {
            height: 300px;
            margin-top: 20px;
        }
        .export-btn {
            background: #28a745;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .export-btn:hover {
            background: #218838;
            color: white;
            text-decoration: none;
        }
        .status-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }
        .status-stat {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 4px;
            text-align: center;
        }
        .status-stat .count {
            font-size: 20px;
            font-weight: bold;
            color: #0dcaf0;
        }
        .status-stat .label {
            color: #666;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="content-wrapper">
        <div class="report-container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3><i class="bi bi-graph-up"></i> Báo cáo doanh thu</h3>
                <a href="?export=excel&date_from=<?= $dateFrom ?>&date_to=<?= $dateTo ?>" class="export-btn">
                    <i class="bi bi-file-excel"></i> Xuất Excel
                </a>
            </div>

            <!-- Date Filter -->
            <form method="GET" class="mb-4">
                <div class="d-flex gap-3 align-items-end">
                    <div>
                        <label>Từ ngày:</label>
                        <input type="date" name="date_from" value="<?= $dateFrom ?>" class="form-control" max="<?= date('Y-m-d') ?>">
                    </div>
                    <div>
                        <label>Đến ngày:</label>
                        <input type="date" name="date_to" value="<?= $dateTo ?>" class="form-control" max="<?= date('Y-m-d') ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-funnel"></i> Lọc
                    </button>
                </div>
            </form>

            <!-- Statistics Cards -->
            <div class="row">
                <div class="col-md-3">
                    <div class="stat-card">
                        <h4>Tổng số đơn hàng</h4>
                        <div class="value"><?= number_format($totalOrders) ?></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <h4>Tổng doanh thu</h4>
                        <div class="value"><?= number_format($revenue['totalRevenue'] ?? 0, 0, ',', '.') ?> VNĐ</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <h4>Phí dịch vụ</h4>
                        <div class="value"><?= number_format($revenue['totalServiceFee'] ?? 0, 0, ',', '.') ?> VNĐ</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <h4>Tổng COD</h4>
                        <div class="value"><?= number_format($revenue['totalCOD'] ?? 0, 0, ',', '.') ?> VNĐ</div>
                    </div>
                </div>
            </div>

            <!-- Revenue Chart -->
            <div class="chart-container">
                <canvas id="revenueChart"></canvas>
            </div>

            <!-- Status Statistics -->
            <div class="status-stats">
                <?php foreach ($statusStats as $stat): ?>
                    <div class="status-stat">
                        <div class="count"><?= number_format($stat['count']) ?></div>
                        <div class="label"><?= htmlspecialchars($stat['tenTrangThai']) ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <script>
        // Date validation
        document.querySelector('input[name="date_from"]').addEventListener('change', function() {
            document.querySelector('input[name="date_to"]').min = this.value;
        });

        document.querySelector('input[name="date_to"]').addEventListener('change', function() {
            document.querySelector('input[name="date_from"]').max = this.value;
        });

        // Revenue Chart
        const ctx = document.getElementById('revenueChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?= json_encode(array_map(function($item) {
                    return date('d/m/Y', strtotime($item['date']));
                }, $dailyRevenue)) ?>,
                datasets: [{
                    label: 'Doanh thu theo ngày',
                    data: <?= json_encode(array_map(function($item) {
                        return $item['revenue'];
                    }, $dailyRevenue)) ?>,
                    borderColor: '#0dcaf0',
                    tension: 0.1,
                    fill: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Biểu đồ doanh thu'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return new Intl.NumberFormat('vi-VN', {
                                    style: 'currency',
                                    currency: 'VND'
                                }).format(value);
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html> 