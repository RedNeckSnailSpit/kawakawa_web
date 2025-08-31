// Main JavaScript functionality for Kawakawa Inc. website

document.addEventListener('DOMContentLoaded', function() {
    // Initialize page-specific functionality
    initializeCurrentPage();
    
    // Set active navigation item
    setActiveNavItem();
});

function initializeCurrentPage() {
    const urlParams = new URLSearchParams(window.location.search);
    const currentPage = urlParams.get('page') || 'home';
    
    if (currentPage === 'item-prices' || currentPage === 'home') {
        initializeItemPrices();
    } else if (currentPage === 'shipping-prices') {
        initializeShippingPrices();
    }
}

function setActiveNavItem() {
    const urlParams = new URLSearchParams(window.location.search);
    const currentPage = urlParams.get('page') || 'home';
    const navLinks = document.querySelectorAll('.nav-links a');
    
    navLinks.forEach(link => {
        link.classList.remove('active');
        const linkUrl = new URL(link.href, window.location.origin);
        const linkParams = new URLSearchParams(linkUrl.search);
        const linkPage = linkParams.get('page') || 'home';
        
        if (linkPage === currentPage) {
            link.classList.add('active');
        }
    });
}

// Item Prices functionality
function initializeItemPrices() {
    if (!document.getElementById('location-input')) return;
    
    const locationInput = document.getElementById('location-input');
    const addRowBtn = document.getElementById('add-row-btn');
    
    // Initialize location autocomplete
    setupLocationAutocomplete(locationInput);
    
    // Add row button functionality
    if (addRowBtn) {
        addRowBtn.addEventListener('click', addPriceRow);
    }
    
    // Initialize first row
    const firstRow = document.querySelector('.price-row');
    if (firstRow) {
        initializePriceRow(firstRow);
    }
    
    // Location change handler
    locationInput.addEventListener('change', function() {
        updateAllPrices();
    });
    
    locationInput.addEventListener('input', function() {
        if (this.value === '') {
            this.value = 'Proxion';
            updateAllPrices();
        }
    });
}

function setupLocationAutocomplete(input) {
    let timeout;
    const container = input.parentElement;
    
    input.addEventListener('input', function() {
        clearTimeout(timeout);
        const query = this.value.trim();
        
        if (query.length < 2) {
            removeSuggestions(container);
            return;
        }
        
        timeout = setTimeout(() => {
            fetchLocationSuggestions(query, container);
        }, 300);
    });
    
    // Hide suggestions when clicking outside
    document.addEventListener('click', function(e) {
        if (!container.contains(e.target)) {
            removeSuggestions(container);
        }
    });
}

function fetchLocationSuggestions(query, container) {
    fetch(`/api/locations/?search=${encodeURIComponent(query)}`)
        .then(response => response.json())
        .then(data => {
            showSuggestions(data.locations || [], container);
        })
        .catch(error => {
            console.error('Error fetching location suggestions:', error);
        });
}

function showSuggestions(locations, container) {
    removeSuggestions(container);
    
    if (locations.length === 0) return;
    
    const suggestionsDiv = document.createElement('div');
    suggestionsDiv.className = 'suggestions';
    
    locations.forEach(location => {
        const item = document.createElement('div');
        item.className = 'suggestion-item';
        item.textContent = location.name;
        item.addEventListener('click', function() {
            container.querySelector('input').value = location.name;
            removeSuggestions(container);
            updateAllPrices();
        });
        suggestionsDiv.appendChild(item);
    });
    
    container.appendChild(suggestionsDiv);
}

function removeSuggestions(container) {
    const existing = container.querySelector('.suggestions');
    if (existing) {
        existing.remove();
    }
}

function addPriceRow() {
    const table = document.getElementById('price-table');
    const tbody = table.querySelector('tbody');
    const newRow = createPriceRow();
    
    tbody.appendChild(newRow);
    initializePriceRow(newRow);
}

function createPriceRow() {
    const row = document.createElement('tr');
    row.className = 'price-row';
    row.innerHTML = `
        <td><button type="button" class="btn btn-danger btn-sm" onclick="removePriceRow(this)">×</button></td>
        <td><input type="text" class="item-ticker" value="RAT" placeholder="Item Ticker"></td>
        <td><input type="number" class="quantity" value="1" min="1" step="1"></td>
        <td class="unit-price">0.00</td>
        <td class="total-price">0.00</td>
    `;
    return row;
}

function initializePriceRow(row) {
    const tickerInput = row.querySelector('.item-ticker');
    const quantityInput = row.querySelector('.quantity');
    
    tickerInput.addEventListener('change', function() {
        updateRowPrice(row);
    });
    
    quantityInput.addEventListener('input', function() {
        updateRowPrice(row);
    });
    
    // Initial price update
    updateRowPrice(row);
}

function updateRowPrice(row) {
    const ticker = row.querySelector('.item-ticker').value.trim().toUpperCase();
    const quantity = parseInt(row.querySelector('.quantity').value) || 1;
    const location = document.getElementById('location-input').value || 'Proxion';
    
    if (!ticker) return;
    
    fetch(`/api/prices/?ticker=${encodeURIComponent(ticker)}&location=${encodeURIComponent(location)}`)
        .then(response => response.json())
        .then(data => {
            const unitPrice = data.price || 0;
            const totalPrice = unitPrice * quantity;
            
            row.querySelector('.unit-price').textContent = unitPrice.toFixed(2);
            row.querySelector('.total-price').textContent = totalPrice.toFixed(2);
            
            updateGrandTotal();
        })
        .catch(error => {
            console.error('Error fetching price:', error);
            row.querySelector('.unit-price').textContent = '0.00';
            row.querySelector('.total-price').textContent = '0.00';
            updateGrandTotal();
        });
}

function updateAllPrices() {
    const rows = document.querySelectorAll('.price-row');
    rows.forEach(row => updateRowPrice(row));
}

function removePriceRow(button) {
    const row = button.closest('tr');
    row.remove();
    updateGrandTotal();
}

function updateGrandTotal() {
    const totalPrices = document.querySelectorAll('.total-price');
    let grandTotal = 0;
    
    totalPrices.forEach(cell => {
        const value = parseFloat(cell.textContent) || 0;
        grandTotal += value;
    });
    
    const grandTotalElement = document.getElementById('grand-total');
    if (grandTotalElement) {
        grandTotalElement.textContent = `Total: ${grandTotal.toFixed(2)}`;
    }
}

// Shipping Prices functionality
function initializeShippingPrices() {
    const fromInput = document.getElementById('from-location');
    const toInput = document.getElementById('to-location');
    const weightInput = document.getElementById('weight');
    const volumeInput = document.getElementById('volume');
    
    if (!fromInput) return;
    
    // Setup autocomplete for both location inputs
    setupLocationAutocomplete(fromInput);
    setupLocationAutocomplete(toInput);
    
    // Add change listeners to update shipping cost
    [fromInput, toInput, weightInput, volumeInput].forEach(input => {
        if (input) {
            input.addEventListener('input', updateShippingCost);
            input.addEventListener('change', updateShippingCost);
        }
    });
}

function updateShippingCost() {
    const fromLocation = document.getElementById('from-location').value.trim();
    const toLocation = document.getElementById('to-location').value.trim();
    const weight = parseFloat(document.getElementById('weight').value) || 0;
    const volume = parseFloat(document.getElementById('volume').value) || 0;
    
    if (!fromLocation || !toLocation || (weight === 0 && volume === 0)) {
        document.getElementById('unit-cost').textContent = '0.00';
        document.getElementById('total-cost').textContent = '0.00';
        return;
    }
    
    fetch(`/api/shipping/?from=${encodeURIComponent(fromLocation)}&to=${encodeURIComponent(toLocation)}`)
        .then(response => response.json())
        .then(data => {
            const unitCost = data.cost || 0;
            const multiplier = Math.max(weight, volume);
            const totalCost = unitCost * multiplier;
            
            document.getElementById('unit-cost').textContent = unitCost.toFixed(2);
            document.getElementById('total-cost').textContent = totalCost.toFixed(2);
        })
        .catch(error => {
            console.error('Error fetching shipping cost:', error);
            document.getElementById('unit-cost').textContent = '0.00';
            document.getElementById('total-cost').textContent = '0.00';
        });
}

// Utility functions
function formatNumber(num, decimals = 2) {
    return num.toLocaleString('en-US', {
        minimumFractionDigits: decimals,
        maximumFractionDigits: decimals
    });
}