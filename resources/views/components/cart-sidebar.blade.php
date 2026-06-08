<div class="cart-overlay" id="cartOverlay" onclick="closeCart()"></div>
<div class="cart-sidebar" id="cartSidebar">
  <div class="cart-header">
    <h3>🛒 Your Cart</h3>
    <button onclick="closeCart()" class="cart-close">✕</button>
  </div>
  <div class="cart-body" id="cartBody">
    <div class="cart-empty">🛒 Cart is empty</div>
  </div>
  <div class="cart-footer" id="cartFooter" style="display:none">
    <div class="cart-total">Total: <span id="cartTotalAmt">₹0</span></div>
    <a href="{{ route('checkout') }}" class="btn-primary" style="display:block;text-align:center;margin-top:12px">Proceed to Checkout →</a>
  </div>
</div>
