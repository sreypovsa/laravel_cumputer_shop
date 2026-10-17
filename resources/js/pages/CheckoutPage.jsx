import React, { useState } from 'react';
import { 
  ShieldCheck, CreditCard, QrCode, CheckCircle2, Truck, 
  MapPin, User, Phone, Mail, ArrowRight, ArrowLeft 
} from 'lucide-react';
import { useShop } from '../context/ShopContext';
import { cambodiaProvinces } from '../data/mockData';
import { AbaPayLogo, AcledaLogo, WingLogo, KhqrLogo, VisaLogo, MastercardLogo } from '../components/BrandAndBankLogos';

export const CheckoutPage = () => {
  const { 
    t, 
    cart, 
    cartSubtotal, 
    deliveryFee, 
    cartTotal, 
    clearCart, 
    navigateTo, 
    lang,
    addToast
  } = useShop();

  const [step, setStep] = useState(1); // 1: Info, 2: Delivery, 3: Payment, 4: Confirmed
  const [formData, setFormData] = useState({
    name: 'Sophea Mean',
    phone: '012 345 678',
    email: 'sophea.mean@example.com',
    province: 'Phnom Penh',
    district: 'Sen Sok',
    commune: 'Teuk Thla',
    village: 'Phum 2',
    street: 'Street 271, House #14B',
    notes: 'Please call 10 minutes before arrival',
    paymentMethod: 'aba' // 'aba', 'acleda', 'wing', 'card', 'cod'
  });

  const [orderNumber, setOrderNumber] = useState('QT-' + Math.floor(10000 + Math.random() * 90000));

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData(prev => ({ ...prev, [name]: value }));
  };

  const handleNextStep = (e) => {
    e.preventDefault();
    if (step < 3) {
      setStep(step + 1);
    } else if (step === 3) {
      // Place order
      const code = 'QT-' + Math.floor(10000 + Math.random() * 90000);
      setOrderNumber(code);
      setStep(4);
      clearCart();
      addToast(
        lang === 'km' ? 'ការបញ្ជាទិញបានជោគជ័យ' : 'Order Placed Successfully',
        `Order code: ${code}`
      );
    }
  };

  return (
    <div className="py-8 bg-[#F8FAFC]">
      <div className="max-w-5xl mx-auto px-4">
        {/* Step indicator header */}
        <div className="mb-8">
          <h1 className="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight text-center">
            {t.checkout.title}
          </h1>
          
          <div className="flex items-center justify-center mt-6 gap-2 sm:gap-4 max-w-xl mx-auto">
            {[
              { num: 1, label: t.checkout.step1.split('. ')[1] },
              { num: 2, label: t.checkout.step2.split('. ')[1] },
              { num: 3, label: t.checkout.step3.split('. ')[1] },
              { num: 4, label: t.checkout.step4.split('. ')[1] },
            ].map((s) => (
              <div key={s.num} className="flex items-center gap-2">
                <div className={`w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold transition-all ${
                  step === s.num
                    ? 'bg-blue-600 text-white ring-4 ring-blue-100'
                    : step > s.num
                    ? 'bg-emerald-600 text-white'
                    : 'bg-slate-200 text-slate-500'
                }`}>
                  {step > s.num ? <CheckCircle2 className="w-4 h-4" /> : s.num}
                </div>
                <span className={`hidden md:inline text-xs font-semibold ${
                  step === s.num ? 'text-slate-900' : 'text-slate-400'
                }`}>
                  {s.label}
                </span>
                {s.num < 4 && <div className="w-4 sm:w-8 h-0.5 bg-slate-200" />}
              </div>
            ))}
          </div>
        </div>

        {/* Step 4: Confirmation Screen */}
        {step === 4 ? (
          <div className="bg-white border border-slate-200 rounded-3xl p-8 sm:p-12 text-center max-w-xl mx-auto shadow-sm space-y-6">
            <div className="w-16 h-16 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto">
              <CheckCircle2 className="w-8 h-8" />
            </div>

            <div>
              <span className="px-3 py-1 bg-emerald-50 text-emerald-700 text-xs font-bold rounded-full uppercase tracking-wider">
                Order Confirmed
              </span>
              <h2 className="text-2xl font-black text-slate-900 mt-2">
                Thank You, {formData.name}!
              </h2>
              <p className="text-xs text-slate-500 mt-1">
                Your order has been registered. We are preparing it for delivery.
              </p>
            </div>

            {/* Order info chip */}
            <div className="p-4 rounded-2xl bg-slate-50 border border-slate-200 text-left space-y-2 text-xs">
              <div className="flex justify-between">
                <span className="text-slate-500">Tracking Code:</span>
                <span className="font-mono font-bold text-blue-600">{orderNumber}</span>
              </div>
              <div className="flex justify-between">
                <span className="text-slate-500">Destination:</span>
                <span className="font-medium text-slate-800">{formData.street}, {formData.province}</span>
              </div>
              <div className="flex justify-between">
                <span className="text-slate-500">Recipient Phone:</span>
                <span className="font-medium text-slate-800">{formData.phone}</span>
              </div>
              <div className="flex justify-between border-t border-slate-200 pt-2 font-bold text-slate-900">
                <span>Amount Paid:</span>
                <span className="text-blue-600">${cartTotal.toFixed(2)}</span>
              </div>
            </div>

            {/* If KHQR selected, simulate KHQR QR box */}
            {['aba', 'acleda', 'wing'].includes(formData.paymentMethod) && (
              <div className="p-5 rounded-2xl bg-blue-50 border border-blue-200 flex flex-col items-center text-center space-y-3">
                <div className="flex items-center gap-2 text-xs font-bold text-blue-900">
                  <QrCode className="w-4 h-4 text-blue-600" />
                  <span>National Bank of Cambodia KHQR Standard</span>
                </div>
                <div className="w-40 h-40 bg-white p-3 rounded-xl border border-slate-300 shadow-xs flex items-center justify-center">
                  {/* Stylized QR mockup */}
                  <div className="w-full h-full border-4 border-dashed border-slate-300 rounded-lg flex flex-col items-center justify-center p-2 text-slate-400">
                    <QrCode className="w-16 h-16 text-slate-800" />
                    <span className="text-[10px] font-bold text-slate-800 mt-1">QUICKTECH KHQR</span>
                  </div>
                </div>
                <p className="text-[11px] text-blue-800 max-w-xs">
                  Scan with your mobile banking app (ABA, Acleda, Wing, Canadia, etc.) to complete transaction.
                </p>
              </div>
            )}

            <div className="flex flex-col sm:flex-row gap-3 pt-2">
              <button
                onClick={() => navigateTo('track', { code: orderNumber })}
                className="flex-1 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition-all shadow-md shadow-blue-600/20 cursor-pointer"
              >
                Track This Order
              </button>
              <button
                onClick={() => navigateTo('home')}
                className="py-3 px-5 border border-slate-300 hover:bg-slate-50 text-slate-700 rounded-xl text-xs font-bold transition-colors cursor-pointer"
              >
                Back to Store
              </button>
            </div>
          </div>
        ) : (
          /* Step 1, 2, 3: Form + Order Summary */
          <div className="grid grid-cols-1 lg:grid-cols-12 gap-8">
            {/* Form Column (7 cols) */}
            <div className="lg:col-span-7 bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-xs">
              <form onSubmit={handleNextStep} className="space-y-6">
                
                {/* Step 1: Customer Information */}
                {step === 1 && (
                  <div className="space-y-4">
                    <div className="flex items-center gap-2 pb-3 border-b border-slate-100">
                      <User className="w-4 h-4 text-blue-600" />
                      <h2 className="text-base font-bold text-slate-900">{t.checkout.step1}</h2>
                    </div>

                    <div>
                      <label className="text-xs font-semibold text-slate-700 block mb-1.5">
                        {t.checkout.fullName} *
                      </label>
                      <input
                        type="text"
                        name="name"
                        required
                        value={formData.name}
                        onChange={handleChange}
                        className="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600"
                        placeholder="e.g. Sokha Mean"
                      />
                    </div>

                    <div>
                      <label className="text-xs font-semibold text-slate-700 block mb-1.5">
                        {t.checkout.phone} *
                      </label>
                      <input
                        type="tel"
                        name="phone"
                        required
                        value={formData.phone}
                        onChange={handleChange}
                        className="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 font-mono"
                        placeholder="012 345 678"
                      />
                    </div>

                    <div>
                      <label className="text-xs font-semibold text-slate-700 block mb-1.5">
                        {t.checkout.email}
                      </label>
                      <input
                        type="email"
                        name="email"
                        value={formData.email}
                        onChange={handleChange}
                        className="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600"
                        placeholder="yourname@gmail.com"
                      />
                    </div>
                  </div>
                )}

                {/* Step 2: Delivery Address (Cambodian format) */}
                {step === 2 && (
                  <div className="space-y-4">
                    <div className="flex items-center gap-2 pb-3 border-b border-slate-100">
                      <MapPin className="w-4 h-4 text-blue-600" />
                      <h2 className="text-base font-bold text-slate-900">{t.checkout.step2}</h2>
                    </div>

                    <div>
                      <label className="text-xs font-semibold text-slate-700 block mb-1.5">
                        {t.checkout.province} *
                      </label>
                      <select
                        name="province"
                        value={formData.province}
                        onChange={handleChange}
                        className="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 cursor-pointer"
                      >
                        {cambodiaProvinces.map((prov) => (
                          <option key={prov} value={prov}>{prov}</option>
                        ))}
                      </select>
                    </div>

                    <div className="grid grid-cols-2 gap-3">
                      <div>
                        <label className="text-xs font-semibold text-slate-700 block mb-1.5">
                          {t.checkout.district} *
                        </label>
                        <input
                          type="text"
                          name="district"
                          required
                          value={formData.district}
                          onChange={handleChange}
                          className="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600"
                          placeholder="e.g. Khan Sen Sok"
                        />
                      </div>
                      <div>
                        <label className="text-xs font-semibold text-slate-700 block mb-1.5">
                          {t.checkout.commune} *
                        </label>
                        <input
                          type="text"
                          name="commune"
                          required
                          value={formData.commune}
                          onChange={handleChange}
                          className="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600"
                          placeholder="e.g. Sangkat Teuk Thla"
                        />
                      </div>
                    </div>

                    <div>
                      <label className="text-xs font-semibold text-slate-700 block mb-1.5">
                        {t.checkout.street} *
                      </label>
                      <input
                        type="text"
                        name="street"
                        required
                        value={formData.street}
                        onChange={handleChange}
                        className="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600"
                        placeholder="e.g. Street 271, House #14B"
                      />
                    </div>

                    <div>
                      <label className="text-xs font-semibold text-slate-700 block mb-1.5">
                        {t.checkout.orderNotes}
                      </label>
                      <textarea
                        name="notes"
                        rows="2"
                        value={formData.notes}
                        onChange={handleChange}
                        className="w-full px-3.5 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600"
                        placeholder="Drop off instructions..."
                      />
                    </div>
                  </div>
                )}

                {/* Step 3: Payment Method */}
                {step === 3 && (
                  <div className="space-y-4">
                    <div className="flex items-center gap-2 pb-3 border-b border-slate-100">
                      <CreditCard className="w-4 h-4 text-blue-600" />
                      <h2 className="text-base font-bold text-slate-900">{t.checkout.step3}</h2>
                    </div>

                    <div className="space-y-2.5">
                      {/* ABA KHQR */}
                      <label className={`flex items-center justify-between p-3.5 rounded-2xl border-2 cursor-pointer transition-all ${
                        formData.paymentMethod === 'aba'
                          ? 'border-blue-600 bg-blue-50/50'
                          : 'border-slate-200 hover:border-slate-300'
                      }`}>
                        <div className="flex items-center gap-3">
                          <input
                            type="radio"
                            name="paymentMethod"
                            value="aba"
                            checked={formData.paymentMethod === 'aba'}
                            onChange={handleChange}
                            className="text-blue-600 focus:ring-blue-500"
                          />
                          <div>
                            <div className="text-xs font-bold text-slate-900">{t.checkout.abaKHQR}</div>
                            <div className="text-[11px] text-slate-500">Scan & pay instantly with ABA Mobile</div>
                          </div>
                        </div>
                        <AbaPayLogo className="h-7" />
                      </label>

                      {/* ACLEDA Mobile */}
                      <label className={`flex items-center justify-between p-3.5 rounded-2xl border-2 cursor-pointer transition-all ${
                        formData.paymentMethod === 'acleda'
                          ? 'border-blue-600 bg-blue-50/50'
                          : 'border-slate-200 hover:border-slate-300'
                      }`}>
                        <div className="flex items-center gap-3">
                          <input
                            type="radio"
                            name="paymentMethod"
                            value="acleda"
                            checked={formData.paymentMethod === 'acleda'}
                            onChange={handleChange}
                            className="text-blue-600 focus:ring-blue-500"
                          />
                          <div>
                            <div className="text-xs font-bold text-slate-900">{t.checkout.acledaKHQR}</div>
                            <div className="text-[11px] text-slate-500">Scan via ACLEDA mobile app</div>
                          </div>
                        </div>
                        <AcledaLogo className="h-7" />
                      </label>

                      {/* Wing Bank */}
                      <label className={`flex items-center justify-between p-3.5 rounded-2xl border-2 cursor-pointer transition-all ${
                        formData.paymentMethod === 'wing'
                          ? 'border-blue-600 bg-blue-50/50'
                          : 'border-slate-200 hover:border-slate-300'
                      }`}>
                        <div className="flex items-center gap-3">
                          <input
                            type="radio"
                            name="paymentMethod"
                            value="wing"
                            checked={formData.paymentMethod === 'wing'}
                            onChange={handleChange}
                            className="text-blue-600 focus:ring-blue-500"
                          />
                          <div>
                            <div className="text-xs font-bold text-slate-900">{t.checkout.wingKHQR}</div>
                            <div className="text-[11px] text-slate-500">Scan with Wing Bank</div>
                          </div>
                        </div>
                        <WingLogo className="h-7" />
                      </label>

                      {/* Visa / Master */}
                      <label className={`flex items-center justify-between p-3.5 rounded-2xl border-2 cursor-pointer transition-all ${
                        formData.paymentMethod === 'card'
                          ? 'border-blue-600 bg-blue-50/50'
                          : 'border-slate-200 hover:border-slate-300'
                      }`}>
                        <div className="flex items-center gap-3">
                          <input
                            type="radio"
                            name="paymentMethod"
                            value="card"
                            checked={formData.paymentMethod === 'card'}
                            onChange={handleChange}
                            className="text-blue-600 focus:ring-blue-500"
                          />
                          <div>
                            <div className="text-xs font-bold text-slate-900">{t.checkout.cardPayment}</div>
                            <div className="text-[11px] text-slate-500">International Visa & MasterCard</div>
                          </div>
                        </div>
                        <div className="flex items-center gap-1.5">
                          <VisaLogo className="h-6" />
                          <MastercardLogo className="h-6" />
                        </div>
                      </label>

                      {/* COD */}
                      <label className={`flex items-center justify-between p-3.5 rounded-2xl border-2 cursor-pointer transition-all ${
                        formData.paymentMethod === 'cod'
                          ? 'border-blue-600 bg-blue-50/50'
                          : 'border-slate-200 hover:border-slate-300'
                      }`}>
                        <div className="flex items-center gap-3">
                          <input
                            type="radio"
                            name="paymentMethod"
                            value="cod"
                            checked={formData.paymentMethod === 'cod'}
                            onChange={handleChange}
                            className="text-blue-600 focus:ring-blue-500"
                          />
                          <div>
                            <div className="text-xs font-bold text-slate-900">{t.checkout.cod}</div>
                            <div className="text-[11px] text-slate-500">Pay when receiving hardware</div>
                          </div>
                        </div>
                        <Truck className="w-5 h-5 text-slate-600" />
                      </label>
                    </div>

                    <div className="p-3 bg-slate-50 rounded-xl text-[11px] text-slate-500 border border-slate-100">
                      {t.checkout.secureNote}
                    </div>
                  </div>
                )}

                {/* Navigation Buttons */}
                <div className="flex items-center justify-between pt-4 border-t border-slate-100">
                  {step > 1 ? (
                    <button
                      type="button"
                      onClick={() => setStep(step - 1)}
                      className="flex items-center gap-1.5 text-xs font-bold text-slate-600 hover:text-slate-900 px-3 py-2 cursor-pointer"
                    >
                      <ArrowLeft className="w-3.5 h-3.5" />
                      <span>Back</span>
                    </button>
                  ) : <div />}

                  <button
                    type="submit"
                    className="px-6 py-3 bg-blue-600 hover:bg-blue-700 active:scale-98 text-white rounded-xl text-xs font-bold transition-all flex items-center gap-2 shadow-md shadow-blue-600/30 cursor-pointer"
                  >
                    <span>{step === 3 ? t.checkout.payNow : 'Continue'}</span>
                    <ArrowRight className="w-3.5 h-3.5" />
                  </button>
                </div>
              </form>
            </div>

            {/* Order Summary Column (5 cols) */}
            <div className="lg:col-span-5 space-y-4">
              <div className="bg-white border border-slate-200 rounded-3xl p-6 shadow-xs space-y-4">
                <h3 className="text-sm font-bold text-slate-900 border-b border-slate-100 pb-3">
                  Items in Order ({cart.length})
                </h3>

                <div className="space-y-3 max-h-60 overflow-y-auto pr-1 divide-y divide-slate-100">
                  {cart.map(item => (
                    <div key={item.product.id} className="pt-2 first:pt-0 flex items-center justify-between text-xs">
                      <div className="flex items-center gap-2.5">
                        <img
                          src={item.product.image}
                          alt={item.product.name}
                          className="w-10 h-10 object-cover rounded-lg border border-slate-200"
                        />
                        <div>
                          <div className="font-semibold text-slate-800 line-clamp-1 max-w-44">
                            {item.product.name}
                          </div>
                          <div className="text-[11px] text-slate-400">Qty: {item.quantity}</div>
                        </div>
                      </div>
                      <div className="font-bold text-slate-900">
                        ${(item.product.price * item.quantity).toFixed(2)}
                      </div>
                    </div>
                  ))}
                </div>

                <div className="space-y-2 pt-3 border-t border-slate-100 text-xs text-slate-600">
                  <div className="flex justify-between">
                    <span>Subtotal</span>
                    <span className="font-semibold text-slate-900">${cartSubtotal.toFixed(2)}</span>
                  </div>
                  <div className="flex justify-between">
                    <span>Delivery</span>
                    <span className="font-semibold">
                      {deliveryFee === 0 ? <span className="text-emerald-600 uppercase font-bold">FREE</span> : `$${deliveryFee.toFixed(2)}`}
                    </span>
                  </div>
                  <div className="flex justify-between text-base font-black text-slate-900 pt-2 border-t border-slate-200">
                    <span>Total Due</span>
                    <span className="text-blue-600">${cartTotal.toFixed(2)}</span>
                  </div>
                </div>
              </div>

              <div className="p-4 rounded-2xl bg-blue-50/60 border border-blue-200/50 text-xs text-blue-900 flex items-start gap-2.5">
                <ShieldCheck className="w-4 h-4 text-blue-600 shrink-0 mt-0.5" />
                <span>QuickTech Cambodia guarantees 100% genuine sealed boxes with valid local serial registration.</span>
              </div>
            </div>
          </div>
        )}
      </div>
    </div>
  );
};
