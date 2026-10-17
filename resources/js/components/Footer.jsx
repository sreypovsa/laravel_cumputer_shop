import React from 'react';
import { Phone, MapPin, Mail, Clock, ShieldCheck, CreditCard, ChevronRight } from 'lucide-react';
import { useShop } from '../context/ShopContext';
import { AbaPayLogo, AcledaLogo, WingLogo, KhqrLogo, VisaLogo, MastercardLogo } from './BrandAndBankLogos';

export const Footer = () => {
  const { t, navigateTo, lang } = useShop();

  return (
    <footer className="bg-[#0F172A] text-slate-400 text-xs border-t border-slate-800">
      {/* Top Value Banner */}
      <div className="border-b border-slate-800 py-8">
        <div className="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-6">
          <div className="flex items-center gap-3">
            <div className="w-10 h-10 rounded-xl bg-blue-600/20 text-blue-400 flex items-center justify-center shrink-0 border border-blue-500/20">
              <ShieldCheck className="w-5 h-5" />
            </div>
            <div>
              <div className="text-white font-bold text-sm">Official Warranty Protection</div>
              <div className="text-slate-400 text-[11px] mt-0.5">Direct partnership with regional distributor centers.</div>
            </div>
          </div>

          <div className="flex items-center gap-3">
            <div className="w-10 h-10 rounded-xl bg-blue-600/20 text-blue-400 flex items-center justify-center shrink-0 border border-blue-500/20">
              <CreditCard className="w-5 h-5" />
            </div>
            <div>
              <div className="text-white font-bold text-sm">Cambodia KHQR Standard</div>
              <div className="text-slate-400 text-[11px] mt-0.5">Instant zero-fee scan with ABA Pay, Acleda & Wing.</div>
            </div>
          </div>

          <div className="flex items-center gap-3">
            <div className="w-10 h-10 rounded-xl bg-blue-600/20 text-blue-400 flex items-center justify-center shrink-0 border border-blue-500/20">
              <Clock className="w-5 h-5" />
            </div>
            <div>
              <div className="text-white font-bold text-sm">Express 24H Nationwide Shipping</div>
              <div className="text-slate-400 text-[11px] mt-0.5">Daily departures to all 25 provinces across Cambodia.</div>
            </div>
          </div>
        </div>
      </div>

      {/* Main Footer Links */}
      <div className="max-w-7xl mx-auto px-4 py-12">
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8 lg:gap-10">
          
          {/* Column 1: Brand Info */}
          <div className="lg:col-span-2 space-y-4">
            <div className="flex items-center gap-2.5">
              <img
                src="/images/quicktech-logo-light.png"
                alt="QuickTech Cambodia"
                className="h-20 w-32 object-contain"
              />
            </div>

            <p className="text-slate-400 leading-relaxed text-xs pr-4">
              {t.footer.aboutText}
            </p>

            <div className="space-y-2 pt-2">
              <div className="flex items-center gap-2 text-slate-300">
                <Phone className="w-4 h-4 text-blue-400 shrink-0" />
                <span className="font-semibold">+855 11 444 888 / +855 96 444 888</span>
              </div>
              <div className="flex items-start gap-2 text-slate-400">
                <MapPin className="w-4 h-4 text-blue-400 shrink-0 mt-0.5" />
                <span>{t.footer.address}</span>
              </div>
              <div className="flex items-center gap-2 text-slate-400">
                <Clock className="w-4 h-4 text-blue-400 shrink-0" />
                <span>{t.footer.hours}</span>
              </div>
            </div>
          </div>

          {/* Column 2: Quick Links */}
          <div className="space-y-3">
            <h4 className="text-sm font-bold text-white uppercase tracking-wider">
              {t.footer.quickLinks}
            </h4>
            <ul className="space-y-2">
              <li>
                <button
                  onClick={() => navigateTo('home')}
                  className="hover:text-blue-400 transition-colors cursor-pointer"
                >
                  {t.nav.home}
                </button>
              </li>
              <li>
                <button
                  onClick={() => navigateTo('category', { category: 'laptops' })}
                  className="hover:text-blue-400 transition-colors cursor-pointer"
                >
                  {t.nav.laptops}
                </button>
              </li>
              <li>
                <button
                  onClick={() => navigateTo('category', { category: 'gaming-laptops' })}
                  className="hover:text-blue-400 transition-colors cursor-pointer"
                >
                  {t.nav.gamingLaptops}
                </button>
              </li>
              <li>
                <button
                  onClick={() => navigateTo('category', { category: 'desktop-pc' })}
                  className="hover:text-blue-400 transition-colors cursor-pointer"
                >
                  {t.nav.desktopPcs}
                </button>
              </li>
              <li>
                <button
                  onClick={() => navigateTo('category', { category: 'pc-components' })}
                  className="hover:text-blue-400 transition-colors cursor-pointer"
                >
                  {t.nav.pcParts}
                </button>
              </li>
              <li>
                <button
                  onClick={() => navigateTo('shop')}
                  className="hover:text-blue-400 transition-colors cursor-pointer"
                >
                  {t.nav.fullShop}
                </button>
              </li>
            </ul>
          </div>

          {/* Column 3: Customer Care */}
          <div className="space-y-3">
            <h4 className="text-sm font-bold text-white uppercase tracking-wider">
              {t.footer.customerCare}
            </h4>
            <ul className="space-y-2">
              <li>
                <button
                  onClick={() => navigateTo('track')}
                  className="hover:text-blue-400 transition-colors cursor-pointer flex items-center gap-1"
                >
                  <span>{t.topbar.trackOrder}</span>
                  <span className="text-[10px] bg-blue-500/20 text-blue-300 px-1.5 py-0.2 rounded font-semibold">Live</span>
                </button>
              </li>
              <li>
                <button
                  onClick={() => navigateTo('account')}
                  className="hover:text-blue-400 transition-colors cursor-pointer"
                >
                  {t.header.account}
                </button>
              </li>
              <li>
                <span className="hover:text-blue-400 cursor-pointer">
                  {t.footer.shippingDelivery || 'Shipping & Delivery'}
                </span>
              </li>
              <li>
                <span className="hover:text-blue-400 cursor-pointer">
                  {t.footer.warrantyPolicy}
                </span>
              </li>
              <li>
                <span className="hover:text-blue-400 cursor-pointer">
                  {t.footer.terms}
                </span>
              </li>
              <li>
                <span className="hover:text-blue-400 cursor-pointer">
                  {t.footer.privacy}
                </span>
              </li>
            </ul>
          </div>

          {/* Column 4: Payment Partners & Cambodia Trust */}
          <div className="space-y-3">
            <h4 className="text-sm font-bold text-white uppercase tracking-wider">
              {t.footer.paymentPartners}
            </h4>
            <p className="text-slate-400 text-xs">
              Accepted through National Bank of Cambodia standard:
            </p>

            {/* Official Bank Logos */}
            <div className="flex flex-wrap items-center gap-2 pt-1">
              <AbaPayLogo className="h-7" />
              <AcledaLogo className="h-7" />
              <WingLogo className="h-7" />
              <KhqrLogo className="h-7" />
              <VisaLogo className="h-7" />
              <MastercardLogo className="h-7" />
            </div>

            <div className="pt-2 text-[11px] text-slate-500">
              Cash on delivery (COD) available for Phnom Penh and provincial express centers.
            </div>
          </div>

        </div>
      </div>

      {/* Bottom Bar */}
      <div className="border-t border-slate-800 py-4 bg-slate-950">
        <div className="max-w-7xl mx-auto px-4 flex flex-col sm:flex-row items-center justify-between gap-3 text-slate-500 text-[11px]">
          <div>{t.footer.copyright}</div>
          <div className="flex items-center gap-4">
            <span className="hover:text-slate-400 cursor-pointer">{t.footer.terms}</span>
            <span>•</span>
            <span className="hover:text-slate-400 cursor-pointer">{t.footer.privacy}</span>
            <span>•</span>
            <span className="hover:text-slate-400 cursor-pointer">{t.footer.warrantyPolicy}</span>
          </div>
        </div>
      </div>
    </footer>
  );
};
