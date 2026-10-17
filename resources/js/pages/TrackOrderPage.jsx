import React, { useState } from 'react';
import { Search, MapPin, Truck, CheckCircle2, Clock, PackageCheck, AlertCircle } from 'lucide-react';
import { useShop } from '../context/ShopContext';
import { mockOrders } from '../data/mockData';

export const TrackOrderPage = () => {
  const { t, lang } = useShop();

  const [inputCode, setInputCode] = useState('QT-88241');
  const [activeOrder, setActiveOrder] = useState(mockOrders[0]);
  const [hasSearched, setHasSearched] = useState(true);

  const handleSearch = (e) => {
    e?.preventDefault();
    const clean = inputCode.trim().toUpperCase();
    const found = mockOrders.find(
      o => o.code.toUpperCase() === clean || o.phone.replace(/\s+/g, '') === clean.replace(/\s+/g, '')
    );
    setActiveOrder(found || null);
    setHasSearched(true);
  };

  const stepsList = [
    { title: t.track.statusConfirmed, icon: CheckCircle2 },
    { title: t.track.statusProcessing, icon: Clock },
    { title: t.track.statusPacked, icon: PackageCheck },
    { title: t.track.statusShipped, icon: Truck },
    { title: t.track.statusOutForDelivery, icon: MapPin },
    { title: t.track.statusDelivered, icon: CheckCircle2 },
  ];

  return (
    <div className="py-10 bg-[#F8FAFC]">
      <div className="max-w-4xl mx-auto px-4">
        {/* Header */}
        <div className="text-center max-w-lg mx-auto mb-8">
          <div className="w-12 h-12 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center mx-auto mb-3">
            <Truck className="w-6 h-6" />
          </div>
          <h1 className="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
            {t.track.title}
          </h1>
          <p className="text-xs sm:text-sm text-slate-500 mt-1">
            {t.track.subtitle}
          </p>
        </div>

        {/* Search Box */}
        <div className="bg-white border border-slate-200 rounded-2xl p-4 sm:p-6 shadow-xs max-w-2xl mx-auto mb-8">
          <form onSubmit={handleSearch} className="flex gap-2">
            <div className="relative flex-1">
              <Search className="w-4 h-4 absolute left-3.5 top-3.5 text-slate-400" />
              <input
                type="text"
                value={inputCode}
                onChange={(e) => setInputCode(e.target.value)}
                placeholder={t.track.inputPlaceholder}
                className="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 uppercase font-mono"
              />
            </div>
            <button
              type="submit"
              className="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs sm:text-sm font-bold transition-all shadow-md shadow-blue-600/20 cursor-pointer"
            >
              {t.track.trackBtn}
            </button>
          </form>

          {/* Demo helper */}
          <div className="mt-3 flex items-center justify-between text-[11px] text-slate-400">
            <span>{t.track.demoNote}</span>
            <div className="flex gap-2">
              <button
                type="button"
                onClick={() => { setInputCode('QT-88241'); }}
                className="text-blue-600 hover:underline cursor-pointer"
              >
                QT-88241
              </button>
              <span>•</span>
              <button
                type="button"
                onClick={() => { setInputCode('QT-99102'); }}
                className="text-blue-600 hover:underline cursor-pointer"
              >
                QT-99102
              </button>
            </div>
          </div>
        </div>

        {/* Results Area */}
        {hasSearched && (
          activeOrder ? (
            <div className="bg-white border border-slate-200 rounded-3xl p-6 sm:p-8 shadow-xs space-y-8 animate-in fade-in duration-200">
              
              {/* Order Status Summary Banner */}
              <div className="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-100">
                <div>
                  <div className="flex items-center gap-2">
                    <span className="font-mono text-lg font-black text-slate-900">
                      {activeOrder.code}
                    </span>
                    <span className="px-2.5 py-0.5 rounded-full text-xs font-bold uppercase tracking-wider bg-blue-50 text-blue-700 border border-blue-200">
                      {activeOrder.status}
                    </span>
                  </div>
                  <div className="text-xs text-slate-400 mt-1">
                    Placed on {activeOrder.date} • {activeOrder.paymentMethod}
                  </div>
                </div>

                <div className="text-left sm:text-right">
                  <div className="text-xs text-slate-400 font-medium">
                    {t.track.estimatedDelivery}
                  </div>
                  <div className="text-sm font-bold text-emerald-600">
                    {activeOrder.estimatedDelivery}
                  </div>
                </div>
              </div>

              {/* Progress Steps Visual (6 Steps) */}
              <div>
                <h3 className="text-xs font-bold text-slate-400 uppercase tracking-wider mb-6">
                  Delivery Timeline
                </h3>
                
                <div className="relative">
                  {/* Connecting Line */}
                  <div className="hidden md:block absolute top-4 left-6 right-6 h-0.5 bg-slate-200 -z-0" />

                  <div className="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-4 relative z-10">
                    {stepsList.map((st, idx) => {
                      const isCompleted = activeOrder.statusCode >= idx + 1;
                      const isCurrent = activeOrder.statusCode === idx + 1;
                      const Icon = st.icon;

                      return (
                        <div key={idx} className="flex flex-col items-center text-center">
                          <div className={`w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold transition-all mb-2 ${
                            isCurrent
                              ? 'bg-blue-600 text-white ring-4 ring-blue-100 shadow-md'
                              : isCompleted
                              ? 'bg-emerald-600 text-white'
                              : 'bg-white border-2 border-slate-300 text-slate-400'
                          }`}>
                            <Icon className="w-4 h-4" />
                          </div>
                          <span className={`text-xs leading-tight font-medium ${
                            isCurrent
                              ? 'text-blue-600 font-bold'
                              : isCompleted
                              ? 'text-slate-800'
                              : 'text-slate-400'
                          }`}>
                            {st.title}
                          </span>
                        </div>
                      );
                    })}
                  </div>
                </div>
              </div>

              {/* Destination & Courier Info */}
              <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-200 text-xs">
                <div>
                  <span className="text-slate-400 block mb-0.5">{t.track.recipient}</span>
                  <div className="font-bold text-slate-900">{activeOrder.customerName}</div>
                  <div className="text-slate-500 font-mono">{activeOrder.phone}</div>
                </div>
                <div>
                  <span className="text-slate-400 block mb-0.5">{t.track.destination}</span>
                  <div className="font-medium text-slate-800 leading-snug">{activeOrder.destination}</div>
                </div>
                <div>
                  <span className="text-slate-400 block mb-0.5">{t.track.courier}</span>
                  <div className="font-bold text-blue-600">{activeOrder.deliveryService}</div>
                  <div className="text-slate-500 font-mono">Waybill: {activeOrder.trackingNumber}</div>
                </div>
              </div>

              {/* Ordered Items List */}
              <div className="space-y-3 pt-2">
                <h4 className="text-xs font-bold text-slate-700 uppercase tracking-wider">
                  Package Contents
                </h4>
                <div className="divide-y divide-slate-100 border border-slate-200 rounded-xl overflow-hidden">
                  {activeOrder.items.map((item, idx) => (
                    <div key={idx} className="p-3 flex items-center justify-between text-xs bg-white">
                      <div className="flex items-center gap-3">
                        <img
                          src={item.image}
                          alt={item.name}
                          className="w-12 h-12 object-cover rounded-lg border border-slate-200"
                        />
                        <div>
                          <div className="font-bold text-slate-900">{item.name}</div>
                          <div className="text-slate-400">Qty: {item.quantity}</div>
                        </div>
                      </div>
                      <div className="font-mono font-bold text-slate-900">
                        ${(item.price * item.quantity).toFixed(2)}
                      </div>
                    </div>
                  ))}
                </div>
              </div>

            </div>
          ) : (
            <div className="bg-white border border-slate-200 rounded-3xl p-10 text-center max-w-md mx-auto space-y-3">
              <AlertCircle className="w-12 h-12 text-slate-400 mx-auto" />
              <h3 className="text-base font-bold text-slate-900">Order Not Found</h3>
              <p className="text-xs text-slate-500">
                We couldn't locate any order with code "{inputCode}". Please verify your order number on your receipt.
              </p>
            </div>
          )
        )}
      </div>
    </div>
  );
};
