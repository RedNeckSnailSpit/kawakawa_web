<div class="card">
    <h2>Item Price Calculator</h2>
    
    <div class="form-group">
        <label for="location-input">Location:</label>
        <div class="input-container">
            <input type="text" id="location-input" value="Proxion" placeholder="Enter location name">
        </div>
    </div>
    
    <table class="price-table" id="price-table">
        <thead>
            <tr>
                <th>Remove</th>
                <th>Item Ticker</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>
            <tr class="price-row">
                <td><button type="button" class="btn btn-danger btn-sm" onclick="removePriceRow(this)">×</button></td>
                <td><input type="text" class="item-ticker" value="RAT" placeholder="Item Ticker"></td>
                <td><input type="number" class="quantity" value="1" min="1" step="1"></td>
                <td class="unit-price">0.00</td>
                <td class="total-price">0.00</td>
            </tr>
        </tbody>
    </table>
    
    <div class="form-group" style="display: flex; align-items: end; gap: 1rem;">
		<div>
			<label for="row-count">Number of rows:</label>
			<input type="number" id="row-count" value="1" min="1" step="1" style="width: 100px;">
		</div>
		<button type="button" class="btn" id="add-row-btn">Set Row</button>
	</div>
    
    <div class="total-display" id="grand-total">
        Total: 0.00
    </div>
</div>