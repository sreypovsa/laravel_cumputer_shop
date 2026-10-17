import React, { useState } from 'react';
import { X, Star, ShoppingBag, ShieldCheck, Truck, Check, Heart, ExternalLink } from 'lucide-react';
import { useShop } from '../context/ShopContext';
import { ProductGallery } from './ProductGallery';

export const QuickViewModal = () => {
  const { 
    quickViewProduct, 
    setQuickViewProduct, 
    addToCart, 
    toggleWishlist, 
    isInWishlist,
    navigateTo,
    lang,
    t
  } = useShop();

  const [quantity, setQuantity] = useState(1);

  if (!quickViewProduct) return null;

  const product = quickViewProduct;
  const isWish = isInWishlist(product.id);

  const handleAdd = () => {
    addToCart(product, quantity);
    setQuickViewProduct(null);
  };

  const handleFullDetail = () => {
    setQuickViewProduct(null);
    navigateTo('product-detail', { product });
  };

  return (
    <div className="fixed inset-0 z-50 flex items-center justify-center p-4">
      {/* Backdrop */}
      <div 
        className="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity"
        onClick={() => setQuickViewProduct(null)}
      />

      {/* Modal Dialog */}
      <div className="relative w-full max-w-3xl bg-white rounded-2xl shadow-2xl border border-slate-200 overflow-hidden z-10 animate-in zoom-in-95 duration-150 max-h-[90vh] flex flex-col">
        {/* Modal Close Button */}
        <button
          onClick={() => setQuickViewProduct(null)}
          className="absolute top-4 right-4 z-20 w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-500 hover:text-slate-800 flex items-center justify-center transition-colors cursor-pointer"
        >
          <X className="w-4 h-4" />
        </button>

        <div className="overflow-y-auto p-6 grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-8">
          {/* Left: Gallery */}
          <div>
            <ProductGallery images={product.gallery} productName={product.name} />
          </div>

          {/* Right: Info & Actions */}
          <div className="flex flex-col justify-between space-y-4">
            <div>
              {/* Brand & Stock */}
              <div className="flex items-center justify-between text-xs mb-1.5">
                <span className="font-bold text-blue-600 uppercase tracking-wider">
                  {product.brand}
                </span>
                <span className="text-emerald-600 font-semibold flex items-center gap-1">
                  <Check className="w-3.5 h-3.5" />
                  <span>{t.productCard.inStock} ({product.stock} units)</span>
                </span>
              </div>

              {/* Title */}
              <h2 className="text-lg sm:text-xl font-bold text-slate-900 leading-snug">
                {lang === 'km' && product.name_km ? product.name_km : product.name}
              </h2>

              {/* Rating & SKU */}
              <div className="flex items-center gap-3 text-xs text-slate-500 mt-2">
                <div className="flex items-center gap-1 text-amber-500 font-semibold">
                  <Star className="w-4 h-4 fill-current" />
                  <span>{product.rating}</span>
                  <span className="text-slate-400 font-normal">({product.reviewsCount} reviews)</span>
                </div>
                <span>•</span>
                <span>SKU: {product.sku}</span>
              </div>

              {/* Price Block */}
              <div className="mt-4 p-3 bg-slate-50 rounded-xl border border-slate-100 flex items-baseline gap-3">
                <span className="text-2xl font-black text-blue-600">
                  ${product.price.toFixed(2)}
                </span>
                {product.originalPrice && product.originalPrice > product.price && (
                  <>
                    <span className="text-sm text-slate-400 line-through">
                      ${product.originalPrice.toFixed(2)}
                    </span>
                    <span className="text-xs font-bold text-red-500 bg-red-50 px-2 py-0.5 rounded">
                      Save ${(product.originalPrice - product.price).toFixed(2)}
                    </span>
                  </>
                )}
              </div>

              {/* Key Specs */}
              <div className="mt-4 space-y-1.5 text-xs text-slate-600">
                <div className="font-semibold text-slate-800 text-[11px] uppercase tracking-wider mb-1">
                  Core Specifications:
                </div>
                <div className="grid grid-cols-2 gap-2 text-xs">
                  <div className="p-2 bg-slate-50 rounded border border-slate-100">
                    <span className="text-[10px] text-slate-400 block">CPU</span>
                    <span className="font-medium text-slate-800 truncate block">{product.specs.cpu}</span>
                  </div>
                  <div className="p-2 bg-slate-50 rounded border border-slate-100">
                    <span className="text-[10px] text-slate-400 block">GPU</span>
                    <span className="font-medium text-blue-700 truncate block">{product.specs.gpu}</span>
                  </div>
                  <div className="p-2 bg-slate-50 rounded border border-slate-100">
                    <span className="text-[10px] text-slate-400 block">RAM</span>
                    <span className="font-medium text-slate-800 truncate block">{product.specs.ram}</span>
                  </div>
                  <div className="p-2 bg-slate-50 rounded border border-slate-100">
                    <span className="text-[10px] text-slate-400 block">Display</span>
                    <span className="font-medium text-slate-800 truncate block">{product.specs.display}</span>
                  </div>
                </div>
              </div>
            </div>

            {/* Quantity + Buttons */}
            <div className="space-y-3 pt-3 border-t border-slate-100">
              <div className="flex items-center gap-3">
                <div className="flex items-center border border-slate-300 rounded-xl overflow-hidden">
                  <button
                    onClick={() => setQuantity(Math.max(1, quantity - 1))}
                    className="w-9 h-9 flex items-center justify-center hover:bg-slate-100 text-slate-600 cursor-pointer text-sm font-bold"
                  >
                    -
                  </button>
                  <span className="w-10 text-center text-sm font-bold text-slate-900">
                    {quantity}
                  </span>
                  <button
                    onClick={() => setQuantity(quantity + 1)}
                    className="w-9 h-9 flex items-center justify-center hover:bg-slate-100 text-slate-600 cursor-pointer text-sm font-bold"
                  >
                    +
                  </button>
                </div>

                {/* Add to Cart */}
                <button
                  onClick={handleAdd}
                  className="flex-1 h-11 bg-blue-600 hover:bg-blue-700 active:scale-98 text-white rounded-xl text-sm font-bold transition-all flex items-center justify-center gap-2 shadow-md shadow-blue-600/20 cursor-pointer"
                >
                  <ShoppingBag className="w-4 h-4" />
                  <span>{t.productCard.addToCart}</span>
                </button>

                {/* Wishlist */}
                <button
                  onClick={() => toggleWishlist(product)}
                  className={`w-11 h-11 rounded-xl border flex items-center justify-center transition-colors cursor-pointer ${
                    isWish
                      ? 'border-red-200 bg-red-50 text-red-500'
                      : 'border-slate-300 hover:border-slate-400 text-slate-600 hover:bg-slate-50'
                  }`}
                >
                  <Heart className={`w-4 h-4 ${isWish ? 'fill-current' : ''}`} />
                </button>
              </div>

              {/* Full details link */}
              <button
                onClick={handleFullDetail}
                className="w-full text-center text-xs font-semibold text-blue-600 hover:underline flex items-center justify-center gap-1 cursor-pointer pt-1"
              >
                <span>View Full Product Specifications & Warranty</span>
                <ExternalLink className="w-3.5 h-3.5" />
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};
