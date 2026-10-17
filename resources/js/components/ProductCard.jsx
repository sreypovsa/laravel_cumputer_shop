import React from 'react';
import { Heart, ShoppingBag, Eye, Check, Gift } from 'lucide-react';
import { useShop } from '../context/ShopContext';

export const ProductCard = ({ product }) => {
  const { 
    t, 
    addToCart, 
    toggleWishlist, 
    isInWishlist, 
    setQuickViewProduct, 
    navigateTo,
    lang 
  } = useShop();

  const isWish = isInWishlist(product.id);
  const discountPercent = product.originalPrice && product.originalPrice > product.price
    ? Math.round(((product.originalPrice - product.price) / product.originalPrice) * 100)
    : 0;

  const handleCardClick = (e) => {
    // If clicking a button inside, let button handler deal with it
    if (e.target.closest('button')) return;
    navigateTo('product-detail', { product });
  };

  const handleAddToCart = (e) => {
    e.stopPropagation();
    addToCart(product, 1);
  };

  const handleWishlist = (e) => {
    e.stopPropagation();
    toggleWishlist(product);
  };

  const handleQuickView = (e) => {
    e.stopPropagation();
    setQuickViewProduct(product);
  };

  return (
    <div
      onClick={handleCardClick}
      className="group relative bg-white border border-slate-200 hover:border-blue-600 rounded-2xl p-3.5 sm:p-4 flex flex-col justify-between transition-all duration-200 hover:-translate-y-1 hover:shadow-lg cursor-pointer"
    >
      <div>
        {/* Top Badges & Actions */}
        <div className="relative aspect-4/3 rounded-xl overflow-hidden bg-slate-50 flex items-center justify-center mb-3.5">
          {/* Discount & Stock Badges */}
          <div className="absolute top-2.5 left-2.5 z-10 flex flex-col gap-1.5 items-start">
            {discountPercent > 0 && (
              <span className="px-2 py-0.5 text-[11px] font-extrabold uppercase tracking-wider bg-red-500 text-white rounded-md shadow-xs">
                -{discountPercent}%
              </span>
            )}
            {product.badge && (
              <span className="px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider bg-blue-600 text-white rounded-md shadow-xs">
                {product.badge}
              </span>
            )}
          </div>

          {/* Wishlist Button */}
          <button
            type="button"
            onClick={handleWishlist}
            aria-label="Add to wishlist"
            className={`absolute top-2.5 right-2.5 z-10 w-8 h-8 rounded-full flex items-center justify-center transition-all cursor-pointer ${
              isWish
                ? 'bg-red-50 text-red-500 shadow-xs'
                : 'bg-white/90 text-slate-400 hover:text-red-500 hover:bg-white shadow-xs'
            }`}
          >
            <Heart className={`w-4 h-4 ${isWish ? 'fill-current' : ''}`} />
          </button>

          {/* Quick View Button on Hover */}
          <button
            type="button"
            onClick={handleQuickView}
            className="absolute bottom-2.5 left-1/2 -translate-x-1/2 z-10 opacity-0 group-hover:opacity-100 transition-opacity duration-200 px-3 py-1.5 bg-slate-900/90 text-white text-xs font-semibold rounded-lg flex items-center gap-1.5 shadow-md cursor-pointer hover:bg-slate-950"
          >
            <Eye className="w-3.5 h-3.5" />
            <span>{t.productCard.quickView}</span>
          </button>

          {/* Product Image */}
          <img
            src={product.image}
            alt={product.name}
            className="w-full h-full object-cover group-hover:scale-104 transition-transform duration-300"
            loading="lazy"
          />
        </div>

        {/* Brand & Stock Status */}
        <div className="flex items-center justify-between gap-2 mb-1.5 text-xs">
          <span className="font-semibold text-blue-600 tracking-wide uppercase text-[11px]">
            {product.brand}
          </span>
          <span className={`text-[11px] font-medium flex items-center gap-1 ${
            product.stockStatus === 'inStock' ? 'text-emerald-600' : 'text-amber-600'
          }`}>
            <span className={`w-1.5 h-1.5 rounded-full ${
              product.stockStatus === 'inStock' ? 'bg-emerald-500' : 'bg-amber-500'
            }`} />
            {product.stockStatus === 'inStock' ? t.productCard.inStock : t.productCard.lowStock}
          </span>
        </div>

        {/* Product Title */}
        <h3 className="text-sm font-bold text-slate-900 group-hover:text-blue-600 transition-colors line-clamp-2 leading-snug mb-2">
          {lang === 'km' && product.name_km ? product.name_km : product.name}
        </h3>

        {/* Key Specification Badges */}
        {product.specs && (
          <div className="space-y-1 mb-3 text-[11px] text-slate-500">
            {product.specs.cpu && (
              <div className="truncate font-medium flex items-center gap-1">
                <span className="text-slate-400">CPU:</span>
                <span className="text-slate-700">{product.specs.cpu.split('(')[0]}</span>
              </div>
            )}
            {product.specs.gpu && (
              <div className="truncate font-medium flex items-center gap-1">
                <span className="text-slate-400">GPU:</span>
                <span className="text-blue-700 font-semibold">{product.specs.gpu.split('(')[0]}</span>
              </div>
            )}
            {product.specs.ram && (
              <div className="truncate font-medium flex items-center gap-1">
                <span className="text-slate-400">RAM/SSD:</span>
                <span className="text-slate-700">{product.specs.ram.split('(')[0]}</span>
              </div>
            )}
          </div>
        )}

        {/* Free gift indicator */}
        {product.freeGifts && (
          <div className="mb-3 flex items-center gap-1 text-[11px] text-emerald-700 bg-emerald-50/80 px-2 py-1 rounded-md border border-emerald-200/50">
            <Gift className="w-3.5 h-3.5 shrink-0 text-emerald-600" />
            <span className="truncate">{t.productCard.freeGift}</span>
          </div>
        )}
      </div>

      {/* Pricing & Add to Cart */}
      <div className="pt-3 border-t border-slate-100 flex items-center justify-between gap-2">
        <div>
          <div className="text-base sm:text-lg font-black text-blue-600 leading-none">
            ${product.price.toFixed(2)}
          </div>
          {product.originalPrice && product.originalPrice > product.price && (
            <div className="text-xs text-slate-400 line-through mt-0.5 font-medium">
              ${product.originalPrice.toFixed(2)}
            </div>
          )}
        </div>

        {/* Add to Cart Button */}
        <button
          type="button"
          onClick={handleAddToCart}
          className="h-10 px-3.5 bg-blue-600 hover:bg-blue-700 active:scale-95 text-white rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 shadow-sm shadow-blue-600/20 cursor-pointer"
        >
          <ShoppingBag className="w-4 h-4" />
          <span className="hidden sm:inline">{t.productCard.addToCart}</span>
        </button>
      </div>
    </div>
  );
};
