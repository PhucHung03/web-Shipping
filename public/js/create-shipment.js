document.addEventListener('DOMContentLoaded', function() {
  // Get all form elements
  const productWeight = document.getElementById('product-weight');
  const productQuantity = document.getElementById('product-quantity');
  const totalWeight = document.getElementById('total-weight');
  const length = document.getElementById('length');
  const width = document.getElementById('width');
  const height = document.getElementById('height');
  const convertedWeight = document.getElementById('converted-weight');
  
  // Quantity control buttons
  const decreaseBtn = document.querySelector('.quantity-decrease');
  const increaseBtn = document.querySelector('.quantity-increase');
  
  // Update total weight when product weight or quantity changes
  function updateTotalWeight() {
    const weight = parseFloat(productWeight.value) || 0;
    const quantity = parseInt(productQuantity.value) || 0;
    const total = weight * quantity;
    totalWeight.value = total;
    updateConvertedWeight();
  }
  
  // Calculate converted weight based on dimensions
  function updateConvertedWeight() {
    const l = parseFloat(length.value) || 0;
    const w = parseFloat(width.value) || 0;
    const h = parseFloat(height.value) || 0;
    
    // Formula: (L x W x H) / 6000
    const volumetricWeight = (l * w * h) / 6000;
    const actualWeight = parseFloat(totalWeight.value) || 0;
    
    // Use the greater of volumetric weight or actual weight
    convertedWeight.value = Math.max(volumetricWeight, actualWeight);
  }
  
  // Event listeners for quantity controls
  decreaseBtn.addEventListener('click', function() {
    const currentValue = parseInt(productQuantity.value) || 0;
    if (currentValue > 1) {
      productQuantity.value = currentValue - 1;
      updateTotalWeight();
    }
  });
  
  increaseBtn.addEventListener('click', function() {
    const currentValue = parseInt(productQuantity.value) || 0;
    productQuantity.value = currentValue + 1;
    updateTotalWeight();
  });
  
  // Event listeners for input changes
  productWeight.addEventListener('input', updateTotalWeight);
  productQuantity.addEventListener('input', updateTotalWeight);
  length.addEventListener('input', updateConvertedWeight);
  width.addEventListener('input', updateConvertedWeight);
  height.addEventListener('input', updateConvertedWeight);
  
  // Initialize calculations
  updateTotalWeight();
}); 