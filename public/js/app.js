// ===== NAVBAR SCROLL =====
window.addEventListener('scroll', () => {
  document.getElementById('navbar')?.classList.toggle('scrolled', window.scrollY > 50);
});

// ===== HAMBURGER =====
document.getElementById('hamburger')?.addEventListener('click', () => {
  document.getElementById('mobileMenu')?.classList.toggle('open');
});

// ===== CART SIDEBAR =====
function openCart() {
  document.getElementById('cartSidebar')?.classList.add('open');
  document.getElementById('cartOverlay')?.classList.add('open');
}
function closeCart() {
  document.getElementById('cartSidebar')?.classList.remove('open');
  document.getElementById('cartOverlay')?.classList.remove('open');
}
document.querySelector('.nav-cart-link')?.addEventListener('click', (e) => {
  e.preventDefault();
  openCart();
});

// Render cart items directly from data
function renderCart(cart, total) {
  const body = document.getElementById('cartBody');
  const footer = document.getElementById('cartFooter');
  if (!body) return;

  const items = Object.values(cart || {});
  if (items.length === 0) {
    body.innerHTML = '<div class="cart-empty">🛒 Cart is empty<br><small>Add parts to get started</small></div>';
    if (footer) footer.style.display = 'none';
    return;
  }

  body.innerHTML = items.map(item => `
    <div class="cart-item">
      <span style="font-size:24px">${item.icon || '⚙️'}</span>
      <div style="flex:1;min-width:0">
        <div class="cart-item-name" style="font-size:13px;font-weight:600">${item.name}</div>
        <div class="cart-item-qty" style="font-size:12px;color:#888">₹${Number(item.price).toLocaleString('en-IN')} × ${item.qty}</div>
      </div>
      <div class="cart-item-price" style="font-size:13px;font-weight:700;color:#00a651;white-space:nowrap">
        ₹${(item.price * item.qty).toLocaleString('en-IN')}
      </div>
      <button class="cart-remove" onclick="removeCartItem(${item.id})" 
        style="background:none;border:none;cursor:pointer;color:#ef4444;font-size:16px;padding:0 4px">✕</button>
    </div>
  `).join('');

  if (footer) {
    footer.style.display = 'block';
    const t = document.getElementById('cartTotalAmt');
    if (t) t.textContent = '₹' + Number(total).toLocaleString('en-IN');
  }
}

// Add to cart
function addToCart(id) {
  const csrf = document.querySelector('meta[name=csrf-token]')?.content;
  fetch('/cart/add', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf },
    body: JSON.stringify({ part_id: id, qty: 1 })
  })
  .then(r => r.json())
  .then(d => {
    if (d.success) {
      // Update badge
      const badge = document.getElementById('navCartCount');
      if (badge) badge.textContent = d.count;
      // Render cart sidebar from response
      renderCart(d.cart, d.total);
      showNotification('' + d.message);
      openCart();
    }
  })
  .catch(err => console.error('Cart error:', err));
}

// Remove from cart
function removeCartItem(id) {
  const csrf = document.querySelector('meta[name=csrf-token]')?.content;
  fetch('/cart/remove', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf },
    body: JSON.stringify({ id })
  })
  .then(r => r.json())
  .then(d => {
    if (d.success) {
      const badge = document.getElementById('navCartCount');
      if (badge) badge.textContent = d.count || 0;
      renderCart(d.cart || {}, d.total || 0);
    }
  });
}

// ===== NOTIFICATION =====
function showNotification(msg) {
  let n = document.querySelector('.notification');
  if (n) n.remove();
  n = document.createElement('div');
  n.className = 'notification';
  n.textContent = msg;
  document.body.appendChild(n);
  setTimeout(() => { n.style.opacity = '0'; }, 2500);
  setTimeout(() => n.remove(), 3000);
}
