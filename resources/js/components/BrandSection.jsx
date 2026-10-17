import React from 'react';
import { brandsData } from '../data/mockData';
import { useShop } from '../context/ShopContext';
import {
  AsusLogo,
  RogLogo,
  MsiLogo,
  AcerLogo,
  LenovoLogo,
  AppleLogo,
  IntelLogo,
  AmdLogo,
  CoolerMasterLogo,
  KingstonLogo,
  CorsairLogo
} from './BrandAndBankLogos';

const brandLogoMap = {
  'ASUS': AsusLogo,
  'ROG': RogLogo,
  'MSI': MsiLogo,
  'Acer': AcerLogo,
  'Lenovo': LenovoLogo,
  'Apple': AppleLogo,
  'Intel': IntelLogo,
  'AMD': AmdLogo,
  'Cooler Master': CoolerMasterLogo,
  'Kingston': KingstonLogo,
  'Corsair': CorsairLogo,
};

export const BrandSection = () => {
  const { t, navigateTo } = useShop();

  const handleBrandClick = (brandName) => {
    navigateTo('shop', { brand: brandName });
  };

  return (
    <section className="py-12 bg-white border-y border-slate-200">
      <div className="max-w-7xl mx-auto px-4">
        {/* Section Header */}
        <div className="text-center max-w-xl mx-auto mb-8">
          <h2 className="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900">
            {t.brands.title}
          </h2>
          <p className="text-sm text-slate-500 mt-1.5">
            {t.brands.subtitle}
          </p>
        </div>

        {/* Brand Chips / Cards with Official SVG Logos */}
        <div className="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3.5 sm:gap-4">
          {brandsData.map((brand, idx) => {
            const LogoComponent = brandLogoMap[brand.name];
            return (
              <button
                key={idx}
                onClick={() => handleBrandClick(brand.name)}
                className="group p-5 rounded-2xl border border-slate-200 hover:border-blue-600 bg-slate-50/50 hover:bg-white flex flex-col items-center justify-center text-center transition-all duration-200 hover:-translate-y-0.5 hover:shadow-md cursor-pointer min-h-[92px]"
              >
                <div className="h-7 flex items-center justify-center group-hover:scale-105 transition-transform duration-200">
                  {LogoComponent ? (
                    <LogoComponent className="h-6" />
                  ) : (
                    <span className="text-lg font-black tracking-wider text-slate-800 group-hover:text-blue-600">
                      {brand.name}
                    </span>
                  )}
                </div>
                <div className="text-[10px] text-slate-400 font-medium mt-2 truncate max-w-full">
                  {brand.subtitle}
                </div>
              </button>
            );
          })}
        </div>
      </div>
    </section>
  );
};
