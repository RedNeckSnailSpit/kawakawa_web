<div class="card">
    <h2>Shipping Cost Calculator</h2>
    
    <div class="form-group">
        <label for="from-location">From Location:</label>
        <div class="input-container">
            <input type="text" id="from-location" placeholder="Enter origin location">
        </div>
    </div>
    
    <div class="form-group">
        <label for="to-location">To Location:</label>
        <div class="input-container">
            <input type="text" id="to-location" placeholder="Enter destination location">
        </div>
    </div>
    
    <div class="form-group">
        <label for="weight">Weight (t):</label>
        <input type="number" id="weight" step="0.01" min="0" placeholder="Weight in tonnes">
    </div>
    
    <div class="form-group">
        <label for="volume">Volume (m³):</label>
        <input type="number" id="volume" step="0.01" min="0" placeholder="Volume in cubic meters">
    </div>
    
    <div class="card" style="margin-top: 2rem;">
        <h3>Shipping Cost</h3>
        <p><strong>Unit Cost:</strong> <span id="unit-cost">0.00</span></p>
        <p><strong>Total Cost:</strong> <span id="total-cost">0.00</span></p>
        <p><em>Total cost is calculated as unit cost × max(weight, volume)</em></p>
    </div>
</div>