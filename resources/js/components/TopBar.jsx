import React from 'react';
import { Truck, ShieldCheck, Headphones, MapPin, ExternalLink, Globe } from 'lucide-react';
import { useShop } from '../context/ShopContext';
import { CambodiaFlag, UkFlag } from './BrandAndBankLogos';

export const TopBar = () => {
  const { t, lang, toggleLang, navigateTo } = useShop();

  return (
    <div className="bg-[#0F172A] text-slate-300 text-xs py-2 px-4 border-b border-slate-800">
      <div className="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-2">
        {/* Left Trust Bulletins */}
        <div className="flex flex-wrap items-center justify-center md:justify-start gap-4 md:gap-6 font-medium">
          <div className="flex items-center gap-1.5 hover:text-white transition-colors">
            <Truck className="w-3.5 h-3.5 text-blue-400" />
            <span>{t.topbar.freeShipping}</span>
          </div>
          <div className="hidden sm:flex items-center gap-1.5 hover:text-white transition-colors">
            <ShieldCheck className="w-3.5 h-3.5 text-blue-400" />
            <span>{t.topbar.warranty}</span>
          </div>
          <div className="hidden lg:flex items-center gap-1.5 hover:text-white transition-colors">
            <Headphones className="w-3.5 h-3.5 text-blue-400" />
            <span>{t.topbar.support}</span>
          </div>
        </div>

        {/* Right Shortcuts & Lang Switcher */}
        <div className="flex items-center gap-4 text-xs">
          <button
            onClick={() => navigateTo('track')}
            className="flex items-center gap-1.5 text-slate-300 hover:text-white transition-colors cursor-pointer"
          >
            <MapPin className="w-3.5 h-3.5 text-blue-400" />
            <span>{t.topbar.trackOrder}</span>
          </button>

          <span className="text-slate-700">|</span>

          <a
            href="/admin"
            className="flex items-center gap-1 text-slate-300 hover:text-white transition-colors"
          >
            <span>{t.topbar.adminPortal}</span>
            <ExternalLink className="w-3 h-3 text-slate-400" />
          </a>

          <span className="text-slate-700">|</span>

          {/* Bilingual Switcher EN | ខ្មែរ with Flags */}
          <button
            onClick={toggleLang}
            className="flex items-center gap-2 px-2.5 py-1 rounded-lg bg-slate-800 hover:bg-slate-700/80 text-slate-200 transition-all border border-slate-700 shadow-xs font-semibold cursor-pointer"
            title="Switch Language / ប្តូរភាសា"
          >
            <div className="flex items-center gap-1">
              <UkFlag className="w-4 h-2.5" />
              <span className={lang === 'en' ? 'text-blue-400 font-extrabold' : 'text-slate-400'}>EN</span>
            </div>
            <span className="text-slate-600">|</span>
            <div className="flex items-center gap-1">
              <CambodiaFlag className="w-4 h-2.5" />
              <span className={lang === 'km' ? 'text-blue-400 font-extrabold' : 'text-slate-400'}>ខ្មែរ</span>
            </div>
          </button>
        </div>
      </div>
    </div>
  );
};
