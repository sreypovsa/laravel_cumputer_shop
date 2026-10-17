import React from 'react';
import { Phone, User, Heart, ShoppingBag, Menu } from 'lucide-react';
import { useShop } from '../context/ShopContext';
import { SearchBar } from './SearchBar';

export const Header = ({ onOpenMobileMenu }) => {
  const { t, cartCount, wishlist, navigateTo, setIsCartOpen } = useShop();

  return (
    <header className="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200">
      <div className="max-w-7xl mx-auto px-4 py-3.5 flex items-center justify-between gap-4 md:gap-8">
        {/* Mobile Menu Button + Logo */}
        <div className="flex items-center gap-3">
          <button
            type="button"
            onClick={onOpenMobileMenu}
            className="lg:hidden p-2 text-slate-700 hover:text-blue-600 hover:bg-slate-100 rounded-lg transition-colors cursor-pointer"
            aria-label="Open Navigation Menu"
          >
            <Menu className="w-5 h-5" />
          </button>

          {/* Store Logo */}
          <button
            onClick={() => navigateTo('home')}
            className="flex items-center text-left group cursor-pointer"
            aria-label="QuickTech Cambodia home"
          >
            <img
              src="/images/quicktech-logo.png"
              alt="QuickTech Cambodia"
              className="h-[76px] w-[125px] object-contain"
            />
          </button>
        </div>

        {/* Center Search Bar */}
        <div className="hidden md:flex flex-1 justify-center px-4">
          <SearchBar />
        </div>

        {/* Right Action Icons & Contact */}
        <div className="flex items-center gap-2 sm:gap-4 md:gap-6">
          {/* Phone Helpline (Desktop) */}
          <a
            href="tel:+85511444888"
            className="hidden xl:flex items-center gap-2.5 text-left hover:opacity-85 transition-opacity"
          >
            <div className="w-9 h-9 rounded-full bg-slate-100 flex items-center justify-center text-blue-600">
              <Phone className="w-4 h-4" />
            </div>
            <div>
              <div className="text-[11px] text-slate-400 font-medium leading-none">
                {t.header.contactUs}
              </div>
              <div className="text-xs font-bold text-slate-900 leading-tight mt-0.5">
                +855 11 444 888
              </div>
            </div>
          </a>

          <div className="hidden xl:block h-6 w-px bg-slate-200" />

          {/* Account */}
          <button
            onClick={() => navigateTo('account')}
            className="flex flex-col items-center justify-center text-slate-700 hover:text-blue-600 transition-colors p-1.5 rounded-lg hover:bg-slate-50 cursor-pointer"
            title={t.header.account}
          >
            <User className="w-5 h-5" />
            <span className="hidden sm:inline text-[11px] font-medium mt-0.5">
              {t.header.account}
            </span>
          </button>

          {/* Wishlist */}
          <button
            onClick={() => navigateTo('account', { tab: 'wishlist' })}
            className="relative flex flex-col items-center justify-center text-slate-700 hover:text-blue-600 transition-colors p-1.5 rounded-lg hover:bg-slate-50 cursor-pointer"
            title={t.header.wishlist}
          >
            <div className="relative">
              <Heart className="w-5 h-5" />
              {wishlist.length > 0 && (
                <span className="absolute -top-1.5 -right-2 bg-blue-600 text-white text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center ring-2 ring-white">
                  {wishlist.length}
                </span>
              )}
            </div>
            <span className="hidden sm:inline text-[11px] font-medium mt-0.5">
              {t.header.wishlist}
            </span>
          </button>

          {/* Cart with Item Count Badge */}
          <button
            onClick={() => setIsCartOpen(true)}
            className="relative flex items-center gap-2 px-3 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-xl font-semibold transition-colors cursor-pointer border border-blue-200/60"
            title={t.header.cart}
          >
            <div className="relative">
              <ShoppingBag className="w-5 h-5" />
              {cartCount > 0 && (
                <span className="absolute -top-2 -right-2.5 bg-red-500 text-white text-[10px] font-bold min-w-4 h-4 px-1 rounded-full flex items-center justify-center ring-2 ring-white">
                  {cartCount}
                </span>
              )}
            </div>
            <span className="hidden sm:inline text-xs font-bold">
              {cartCount} {t.header.items}
            </span>
          </button>
        </div>
      </div>

      {/* Mobile Search Bar below header */}
      <div className="md:hidden px-4 pb-3">
        <SearchBar />
      </div>
    </header>
  );
};
