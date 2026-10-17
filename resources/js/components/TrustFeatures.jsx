import React from 'react';
import { ShieldCheck, Truck, Wrench, CreditCard } from 'lucide-react';
import { useShop } from '../context/ShopContext';

export const TrustFeatures = () => {
  const { t } = useShop();

  const features = [
    {
      icon: ShieldCheck,
      title: t.trust.genuineTitle,
      description: t.trust.genuineDesc,
    },
    {
      icon: Truck,
      title: t.trust.deliveryTitle,
      description: t.trust.deliveryDesc,
    },
    {
      icon: Wrench,
      title: t.trust.warrantyTitle,
      description: t.trust.warrantyDesc,
    },
    {
      icon: CreditCard,
      title: t.trust.paymentTitle,
      description: t.trust.paymentDesc,
    },
  ];

  return (
    <section className="bg-white border-b border-slate-200 py-6 sm:py-8">
      <div className="max-w-7xl mx-auto px-4">
        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
          {features.map((item, idx) => {
            const Icon = item.icon;
            return (
              <div
                key={idx}
                className="flex items-center gap-4 p-4 rounded-xl border border-slate-100 hover:border-slate-300 hover:shadow-xs bg-slate-50/50 hover:bg-white transition-all"
              >
                <div className="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 border border-blue-100">
                  <Icon className="w-6 h-6" />
                </div>
                <div>
                  <h4 className="text-sm font-bold text-slate-900 leading-tight">
                    {item.title}
                  </h4>
                  <p className="text-xs text-slate-500 mt-0.5 leading-snug">
                    {item.description}
                  </p>
                </div>
              </div>
            );
          })}
        </div>
      </div>
    </section>
  );
};
