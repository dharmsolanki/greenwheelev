<div class="cart-overlay" id="cartOverlay" onclick="closeCart()"></div>
<div class="cart-sidebar" id="cartSidebar">
  <div class="cart-header">
    <h3><i class="fas fa-shopping-cart"></i> Your Cart</h3>
    <button onclick="closeCart()" class="cart-close"><i class="fas fa-times"></i></button>
  </div>
  <div class="cart-body" id="cartBody">
    <div class="cart-empty"><i class="fas fa-shopping-cart" style="font-size:32px;color:#ddd;display:block;margin-bottom:10px"></i>Cart is empty</div>
  </div>
  <div class="cart-footer" id="cartFooter" style="display:none">
    <div class="cart-total">Total: <span id="cartTotalAmt">₹0</span></div>
    <a href="{{ route('checkout') }}" class="btn-primary" style="display:block;text-align:center;margin-top:12px">Proceed to Checkout <i class="fas fa-arrow-right"></i></a>
  </div>
</div>
