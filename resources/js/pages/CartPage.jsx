import React from 'react';
import { ShoppingBag, ArrowRight, Trash2, Plus, Minus, Truck, ShieldCheck, ArrowLeft } from 'lucide-react';
import { useShop } from '../context/ShopContext';

export const CartPage = () => {
  const { 
    t, 
    cart, 
    updateQuantity, 
    removeFromCart, 
    clearCart, 
    cartSubtotal, 
    deliveryFee, 
    cartTotal,
    navigateTo,
    lang 
  } = useShop();

  const freeShippingThreshold = 100;
  const progressPercent = Math.min(100, Math.round((cartSubtotal / freeShippingThreshold) * 100));
  const remainingForFreeShipping = Math.max(0, freeShippingThreshold - cartSubtotal);

  if (cart.length === 0) {
    return (
      <div className="py-20 bg-[#F8FAFC]">
        <div className="max-w-md mx-auto px-4 text-center space-y-4">
          <div className="w-20 h-20 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto">
            <ShoppingBag className="w-10 h-10" />
          </div>
          <h2 className="text-xl font-bold text-slate-900">{t.cart.empty}</h2>
          <p className="text-xs text-slate-500">{t.cart.emptyDesc}</p>
          <button
            onClick={() => navigateTo('shop')}
            className="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition-all shadow-md shadow-blue-600/20 cursor-pointer"
          >
            {t.cart.startShopping}
          </button>
        </div>
      </div>
    );
  }

  return (
    <div className="py-8 bg-[#F8FAFC]">
      <div className="max-w-7xl mx-auto px-4">
        {/* Title */}
        <div className="mb-6 flex items-center justify-between">
          <h1 className="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
            {t.cart.title}
          </h1>
          <button
            onClick={clearCart}
            className="text-xs text-slate-500 hover:text-red-600 font-semibold cursor-pointer"
          >
            Clear Cart
          </button>
        </div>

        {/* Free Shipping Alert Banner */}
        <div className="mb-6 p-4 rounded-2xl bg-white border border-slate-200 shadow-xs">
          {cartSubtotal >= freeShippingThreshold ? (
            <div className="flex items-center gap-2 text-emerald-700 font-bold text-xs sm:text-sm">
              <Truck className="w-5 h-5 text-emerald-600" />
              <span>{t.cart.freeShippingNotice}</span>
            </div>
          ) : (
            <div className="space-y-2">
              <div className="flex justify-between text-xs text-slate-700 font-medium">
                <span>{t.cart.freeShippingGoal}<strong>${remainingForFreeShipping.toFixed(2)}</strong> {t.cart.freeShippingGoalEnd}</span>
                <span className="font-bold text-blue-600">{progressPercent}%</span>
              </div>
              <div className="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                <div
                  className="bg-blue-600 h-full rounded-full transition-all duration-300"
                  style={{ width: `${progressPercent}%` }}
                />
              </div>
            </div>
          )}
        </div>

        {/* Main Grid: Products Table + Order Summary */}
        <div className="grid grid-cols-1 lg:grid-cols-12 gap-8">
          
          {/* Cart Items (8 cols) */}
          <div className="lg:col-span-8 bg-white border border-slate-200 rounded-3xl p-6 shadow-xs divide-y divide-slate-100">
            {cart.map((item) => (
              <div key={item.product.id} className="py-4 first:pt-0 last:pb-0 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div className="flex items-center gap-4">
                  <img
                    src={item.product.image}
                    alt={item.product.name}
                    className="w-20 h-20 object-cover rounded-xl border border-slate-200 shrink-0 bg-slate-50"
                  />
                  <div>
                    <span className="text-[11px] font-bold text-blue-600 uppercase">
                      {item.product.brand}
                    </span>
                    <h3 className="text-sm font-bold text-slate-900 line-clamp-1">
                      {lang === 'km' && item.product.name_km ? item.product.name_km : item.product.name}
                    </h3>
                    <div className="text-xs text-slate-500 font-medium mt-0.5">
                      ${item.product.price.toFixed(2)} each
                    </div>
                  </div>
                </div>

                <div className="flex items-center justify-between sm:justify-end gap-6 w-full sm:w-auto">
                  {/* Quantity Control */}
                  <div className="flex items-center border border-slate-300 rounded-xl overflow-hidden bg-white">
                    <button
                      onClick={() => updateQuantity(item.product.id, -1)}
                      className="w-8 h-8 flex items-center justify-center hover:bg-slate-100 text-slate-700 cursor-pointer"
                    >
                      <Minus className="w-3 h-3" />
                    </button>
                    <span className="w-8 text-center text-xs font-bold text-slate-900">
                      {item.quantity}
                    </span>
                    <button
                      onClick={() => updateQuantity(item.product.id, 1)}
                      className="w-8 h-8 flex items-center justify-center hover:bg-slate-100 text-slate-700 cursor-pointer"
                    >
                      <Plus className="w-3 h-3" />
                    </button>
                  </div>

                  {/* Item Subtotal */}
                  <div className="text-right min-w-20">
                    <div className="text-sm font-black text-slate-900">
                      ${(item.product.price * item.quantity).toFixed(2)}
                    </div>
                  </div>

                  {/* Remove Button */}
                  <button
                    onClick={() => removeFromCart(item.product.id)}
                    className="text-slate-400 hover:text-red-500 p-1.5 cursor-pointer transition-colors"
                    title="Remove item"
                  >
                    <Trash2 className="w-4 h-4" />
                  </button>
                </div>
              </div>
            ))}

            <div className="pt-4 flex items-center justify-between">
              <button
                onClick={() => navigateTo('shop')}
                className="flex items-center gap-1.5 text-xs font-bold text-blue-600 hover:underline cursor-pointer"
              >
                <ArrowLeft className="w-3.5 h-3.5" />
                <span>{t.cart.continueShopping}</span>
              </button>
            </div>
          </div>

          {/* Order Summary (4 cols) */}
          <div className="lg:col-span-4">
            <div className="bg-white border border-slate-200 rounded-3xl p-6 shadow-xs space-y-5 sticky top-24">
              <h2 className="text-base font-bold text-slate-900 border-b border-slate-100 pb-3">
                Order Summary
              </h2>

              <div className="space-y-3 text-xs">
                <div className="flex justify-between text-slate-600">
                  <span>{t.cart.subtotal}</span>
                  <span className="font-semibold text-slate-900">${cartSubtotal.toFixed(2)}</span>
                </div>
                <div className="flex justify-between text-slate-600">
                  <span>{t.cart.deliveryFee}</span>
                  <span className="font-semibold">
                    {deliveryFee === 0 ? (
                      <span className="text-emerald-600 font-bold uppercase">{t.cart.free}</span>
                    ) : (
                      `$${deliveryFee.toFixed(2)}`
                    )}
                  </span>
                </div>
                <div className="flex justify-between text-base font-black text-slate-900 pt-3 border-t border-slate-200">
                  <span>{t.cart.total}</span>
                  <span className="text-blue-600 text-xl">${cartTotal.toFixed(2)}</span>
                </div>
              </div>

              <button
                onClick={() => navigateTo('checkout')}
                className="w-full py-3.5 bg-blue-600 hover:bg-blue-700 active:scale-98 text-white rounded-xl text-sm font-bold transition-all flex items-center justify-center gap-2 shadow-lg shadow-blue-600/30 cursor-pointer"
              >
                <span>{t.cart.proceedCheckout}</span>
                <ArrowRight className="w-4 h-4" />
              </button>

              <div className="pt-3 border-t border-slate-100 space-y-2 text-[11px] text-slate-500">
                <div className="flex items-center gap-2">
                  <ShieldCheck className="w-4 h-4 text-emerald-600 shrink-0" />
                  <span>100% Authentic products with brand warranty</span>
                </div>
                <div className="flex items-center gap-2">
                  <Truck className="w-4 h-4 text-blue-600 shrink-0" />
                  <span>Fast delivery across all provinces</span>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  );
};
