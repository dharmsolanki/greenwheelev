@extends('layouts.app')
@section('title','Checkout')
@section('content')
<section class="section" style="padding-top:90px">
  <div class="section-inner">
    <h2 class="section-title">Checkout</h2>
    <div class="checkout-grid">
      <div>
        <div class="form-card">
          <h3 class="form-title">Delivery Details</h3>
          <form id="checkoutForm">
            @csrf
            <div class="form-grid">
              <div class="form-group"><label>Full Name *</label><input type="text" id="c-name" name="name" required></div>
              <div class="form-group"><label>Phone *</label><input type="tel" id="c-phone" name="phone" required></div>
              <div class="form-group"><label>Email</label><input type="email" id="c-email" name="email"></div>
              <div class="form-group"><label>Pincode *</label><input type="text" id="c-pin" name="pincode" required maxlength="6"></div>
              <div class="form-group full"><label>Address *</label><textarea id="c-addr" name="address" required rows="2"></textarea></div>
              <div class="form-group"><label>City *</label><input type="text" id="c-city" name="city" required></div>
              <div class="form-group"><label>State *</label><select id="c-state" name="state" required>
                <option>Gujarat</option><option>Rajasthan</option><option>Maharashtra</option><option>Madhya Pradesh</option><option>Uttar Pradesh</option><option>Other</option>
              </select></div>
              <div class="form-group full"><label>Notes</label><textarea name="notes" rows="2" placeholder="Any delivery instructions..."></textarea></div>
            </div>
          </form>
        </div>
      </div>
      <div>
        <div class="order-summary">
          <h3 class="form-title">Order Summary</h3>
          @foreach($cart as $item)
          <div class="summary-item">
            <span>{{ $item['icon'] }} {{ $item['name'] }} × {{ $item['qty'] }}</span>
            <span>₹{{ number_format($item['price'] * $item['qty']) }}</span>
          </div>
          @endforeach
          <div class="summary-divider"></div>
          <div class="summary-item"><span>Subtotal</span><span>₹{{ number_format($total) }}</span></div>
          <div class="summary-item"><span>Shipping</span><span class="green-text">{{ $total >= 500 ? 'FREE' : '₹80' }}</span></div>
          <div class="summary-total"><span>Total</span><span>₹{{ number_format($total >= 500 ? $total : $total + 80) }}</span></div>
          <div class="payment-methods" style="margin-top:20px">
            <button onclick="placeCOD()" class="btn-cod">📦 Cash on Delivery</button>
            <button onclick="payRazorpay()" class="btn-razorpay">💳 Pay Online (UPI/Card)</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
@push('scripts')
<script>
const RAZORPAY_KEY = '{{ \App\Models\Setting::get("razorpay_key_id","YOUR_KEY") }}';
function getFormData() {
  const f = document.getElementById('checkoutForm');
  if(!f.checkValidity()){f.reportValidity();return null;}
  return {name:f.name.value,phone:f.phone.value,email:f.email?.value,address:f['address'].value,city:f.city.value,state:f.state.value,pincode:f.pincode.value,notes:f.notes?.value};
}
function placeCOD(){
  const d=getFormData();if(!d)return;
  const form=document.createElement('form');form.method='POST';form.action='{{ route("order.cod") }}';
  const csrf=document.createElement('input');csrf.type='hidden';csrf.name='_token';csrf.value='{{ csrf_token() }}';form.appendChild(csrf);
  Object.entries(d).forEach(([k,v])=>{const i=document.createElement('input');i.type='hidden';i.name=k;i.value=v;form.appendChild(i);});
  document.body.appendChild(form);form.submit();
}
function payRazorpay(){
  const d=getFormData();if(!d)return;
  fetch('{{ route("order.razorpay.create") }}',{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'},body:JSON.stringify(d)})
  .then(r=>r.json()).then(res=>{
    const options={key:RAZORPAY_KEY,amount:res.amount,currency:'INR',name:'Green Wheel EV',description:'Spare Parts Order',
      handler:function(resp){
        fetch('{{ route("order.razorpay.verify") }}',{method:'POST',headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'},
          body:JSON.stringify({...d,payment_id:resp.razorpay_payment_id,razorpay_order_id:res.order_id})})
        .then(r=>r.json()).then(v=>{ if(v.success) window.location='{{ url("order") }}/'+v.order_no+'/success'; });
      },
      prefill:{name:d.name,contact:d.phone,email:d.email},theme:{color:'#00a651'}};
    new Razorpay(options).open();
  });
}
</script>
@endpush
