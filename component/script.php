<script src="public/js/jquery-3.7.1.min.js"></script>
<script src="public/js/bootstrap.bundle.min.js"></script>
<script src="../js/create-shipment.js"></script>
<!-- api lay ds tinh -->
<script>
    // Load Tỉnh/Thành phố
    fetch("https://provinces.open-api.vn/api/p/")
        .then(res => res.json())
        .then(data => {
            const provinceSelect = document.getElementById("provinceSelect");
            data.forEach(p => {
                let option = document.createElement("option");
                option.value = p.name; // 🔁 lưu TÊN thay vì CODE
                option.text = p.name;
                provinceSelect.appendChild(option);
            });
        });

    // Load Quận/Huyện theo Tỉnh
    function loadDistricts(provinceCode) {
        const districtSelect = document.getElementById("districtSelect");
        const wardSelect = document.getElementById("wardSelect");
        districtSelect.innerHTML = `<option value="">-- Chọn Quận/Huyện --</option>`;
        wardSelect.innerHTML = `<option value="">-- Chọn Phường/Xã --</option>`;

        if (!provinceCode) return;

        // Vì chúng ta dùng name, cần tìm lại code từ tên
        fetch(`https://provinces.open-api.vn/api/p/`)
            .then(res => res.json())
            .then(provinces => {
                const found = provinces.find(p => p.name === provinceCode);
                if (!found) return;

                fetch(`https://provinces.open-api.vn/api/p/${found.code}?depth=2`)
                    .then(res => res.json())
                    .then(data => {
                        data.districts.forEach(d => {
                            let option = document.createElement("option");
                            option.value = d.name; // 🔁 lưu tên
                            option.text = d.name;
                            districtSelect.appendChild(option);
                        });
                    });
            });
    }

    // Load Phường/Xã theo Quận
    function loadWards(districtName) {
        const wardSelect = document.getElementById("wardSelect");
        wardSelect.innerHTML = `<option value="">-- Chọn Phường/Xã --</option>`;

        if (!districtName) return;

        // Tìm mã quận dựa vào tên
        fetch(`https://provinces.open-api.vn/api/d/`)
            .then(res => res.json())
            .then(districts => {
                const found = districts.find(d => d.name === districtName);
                if (!found) return;

                fetch(`https://provinces.open-api.vn/api/d/${found.code}?depth=2`)
                    .then(res => res.json())
                    .then(data => {
                        data.wards.forEach(w => {
                            let option = document.createElement("option");
                            option.value = w.name; // ✅ lưu tên
                            option.text = w.name;
                            wardSelect.appendChild(option);
                        });
                    });
            });
    }
</script>


<script>
    let productIndex = 1;

    const productFormGroup = document.getElementById('productFormGroup');
    const addProductBtn = document.getElementById('addProductBtn');
    const totalWeightEl = document.getElementById('totalWeight');

    function calculateTotalWeight() {
        let total = 0;
        const weights = document.querySelectorAll('.product-weight');
        const quantities = document.querySelectorAll('.product-quantity');

        weights.forEach((weightInput, index) => {
            const weight = parseFloat(weightInput.value) || 0;
            const quantity = parseInt(quantities[index].value) || 0;
            total += weight * quantity;
        });

        totalWeightEl.textContent = total;
    }

    function attachWeightListeners() {
        const weightInputs = document.querySelectorAll('.product-weight');
        const quantityInputs = document.querySelectorAll('.product-quantity');

        weightInputs.forEach(input => {
            input.removeEventListener('input', calculateTotalWeight); // tránh gắn trùng
            input.addEventListener('input', calculateTotalWeight);
        });

        quantityInputs.forEach(input => {
            input.removeEventListener('input', calculateTotalWeight);
            input.addEventListener('input', calculateTotalWeight);
        });
    }

    attachWeightListeners(); // gắn lần đầu

    addProductBtn.addEventListener('click', function () {
        productIndex++;

        const newRow = document.createElement('div');
        newRow.className = 'product-form-row';
        newRow.setAttribute('data-index', productIndex);

        newRow.innerHTML = `
            <div class="form-field">
                <label class="required">SP ${productIndex}</label>
                <input type="text" placeholder="Nhập tên sản phẩm" class="form-control" name="product-name[]">
            </div>
            <div class="form-field">
                <label class="required">KL (gram)</label>
                <input type="number" value="200" class="form-control product-weight" name="product-weight[]">
            </div>
            <div class="form-field">
                <label class="required">Số lượng</label>
                <div class="quantity-control">
                    <input type="number" value="1" min="1" class="form-control product-quantity" name="product-quantity[]">
                </div>
            </div>
            <div class="form-field">
                <label>Mã sản phẩm</label>
                <input type="text" placeholder="Nhập mã sản phẩm" class="form-control" name="product-code[]">
            </div>
        `;

        productFormGroup.appendChild(newRow);
        attachWeightListeners(); // gắn listener cho input mới
        calculateTotalWeight(); // cập nhật tổng luôn
    });
</script>

<script>
function formatCurrency(value) {
    return value.toLocaleString("vi-VN") + " đ";
}

let currentShipCost = 0;
let currentKhaiGia = 0;
let currentCod = 0;

function updateShipCost() {
    const weightInput = document.getElementById("total-weight");
    const costShipView = document.getElementById("cost-ship-view");
    const costShipInput = document.getElementById("cost-ship");

    const weight = parseFloat(weightInput.value) || 0;

    if (weight > 0) {
        currentShipCost = weight > 20000 ? 80000 : 24000;
        costShipView.textContent = formatCurrency(currentShipCost);
        costShipInput.value = currentShipCost;
    } else {
        currentShipCost = 0;
        costShipView.textContent = "";
        costShipInput.value = "";
    }

    updateTotalCost();
}

function updateCodCost() {
    const codInput = document.getElementById("COD");
    const codShipView = document.getElementById("cod-ship-view");
    const codShipInput = document.getElementById("cod-ship");

    const khaiGiaView = document.getElementById("phiKhaiGia-view");
    const khaiGiaInput = document.getElementById("phiKhaiGia");

    const codValueRaw = codInput.value.replace(/\./g, "").replace(",", ".");
    const codAmount = parseFloat(codValueRaw);

    if (!isNaN(codAmount) && codAmount > 0) {
        currentCod = codAmount;
        codShipView.textContent = formatCurrency(currentCod);
        codShipInput.value = currentCod;

        if (codAmount >= 1000000) {
            currentKhaiGia = Math.round(codAmount * 0.005);
            khaiGiaView.textContent = formatCurrency(currentKhaiGia);
            khaiGiaInput.value = currentKhaiGia;
        } else {
            currentKhaiGia = 0;
            khaiGiaView.textContent = "";
            khaiGiaInput.value = "";
        }
    } else {
        currentCod = 0;
        currentKhaiGia = 0;
        codShipView.textContent = "";
        codShipInput.value = "";
        khaiGiaView.textContent = "";
        khaiGiaInput.value = "";
    }

    updateTotalCost();
}

function updateTotalCost() {
    const totalView = document.getElementById("total-costShip-view");
    const totalInput = document.getElementById("total-costShip");

    const total = currentShipCost + currentCod + currentKhaiGia;

    if (total > 0) {
        totalView.textContent = formatCurrency(total);
        totalInput.value = total;
    } else {
        totalView.textContent = "";
        totalInput.value = "";
    }
}

window.addEventListener("DOMContentLoaded", function () {
    document.getElementById("total-weight").addEventListener("input", updateShipCost);
    document.getElementById("COD").addEventListener("input", updateCodCost);
});

</script>

<!-- script tim kiem -->
<script>
        function filterOrders() {
            const search = document.getElementById('searchInput').value.toLowerCase();
            const status = document.getElementById('statusFilter').value;
            const date = document.getElementById('dateFilter').value;
            const rows = document.querySelectorAll('#orderTableBody tr');

            rows.forEach(row => {
                const orderId = row.cells[1].textContent.toLowerCase();
                const sender = row.cells[2].textContent.toLowerCase();
                const receiver = row.cells[3].textContent.toLowerCase();
                const rowStatus = row.getAttribute('data-status');
                const rowDate = row.getAttribute('data-date');

                const matchesSearch = !search || 
                    orderId.includes(search) || 
                    sender.includes(search) || 
                    receiver.includes(search);
                const matchesStatus = status === 'all' || rowStatus === status;
                const matchesDate = !date || rowDate === date;

                if (matchesSearch && matchesStatus && matchesDate) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
</script>



