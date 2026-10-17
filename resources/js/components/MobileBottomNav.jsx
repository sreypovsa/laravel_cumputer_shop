import React from 'react';
import { Home, Store, Search, Heart, ShoppingBag } from 'lucide-react';
import { useShop } from '../context/ShopContext';

export const MobileBottomNav = ({ onOpenSearch }) => {
  const { activePage, navigateTo, cartCount, wishlist, setIsCartOpen } = useShop();

  return (
    <nav className="lg:hidden fixed bottom-0 left-0 right-0 z-40 bg-white/95 backdrop-blur-md border-t border-slate-200 py-1.5 px-4 shadow-lg">
      <div className="flex items-center justify-around">
        {/* Home */}
        <button
          onClick={() => navigateTo('home')}
          className={`flex flex-col items-center justify-center p-1.5 rounded-lg transition-colors cursor-pointer ${
            activePage === 'home' ? 'text-blue-600 font-bold' : 'text-slate-500'
          }`}
        >
          <Home className="w-5 h-5" />
          <span className="text-[10px] mt-0.5">Home</span>
        </button>

        {/* Shop */}
        <button
          onClick={() => navigateTo('shop')}
          className={`flex flex-col items-center justify-center p-1.5 rounded-lg transition-colors cursor-pointer ${
            activePage === 'shop' || activePage === 'category' ? 'text-blue-600 font-bold' : 'text-slate-500'
          }`}
        >
          <Store className="w-5 h-5" />
          <span className="text-[10px] mt-0.5">Shop</span>
        </button>

        {/* Wishlist */}
        <button
          onClick={() => navigateTo('account', { tab: 'wishlist' })}
          className={`relative flex flex-col items-center justify-center p-1.5 rounded-lg transition-colors cursor-pointer ${
            activePage === 'account' ? 'text-blue-600 font-bold' : 'text-slate-500'
          }`}
        >
          <div className="relative">
            <Heart className="w-5 h-5" />
            {wishlist.length > 0 && (
              <span className="absolute -top-1 -right-2 bg-blue-600 text-white text-[9px] font-bold w-3.5 h-3.5 rounded-full flex items-center justify-center">
                {wishlist.length}
              </span>
            )}
          </div>
          <span className="text-[10px] mt-0.5">Wishlist</span>
        </button>

        {/* Cart */}
        <button
          onClick={() => setIsCartOpen(true)}
          className="relative flex flex-col items-center justify-center p-1.5 rounded-lg text-slate-500 hover:text-blue-600 transition-colors cursor-pointer"
        >
          <div className="relative">
            <ShoppingBag className="w-5 h-5" />
            {cartCount > 0 && (
              <span className="absolute -top-1 -right-2 bg-red-500 text-white text-[9px] font-bold min-w-3.5 h-3.5 px-0.5 rounded-full flex items-center justify-center">
                {cartCount}
              </span>
            )}
          </div>
          <span className="text-[10px] mt-0.5">Cart</span>
        </button>
      </div>
    </nav>
  );
};
