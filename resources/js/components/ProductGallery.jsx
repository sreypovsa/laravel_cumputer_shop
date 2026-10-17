import React, { useState } from 'react';

export const ProductGallery = ({ images = [], productName }) => {
  const [activeIdx, setActiveIdx] = useState(0);

  const displayImages = images.length > 0 ? images : [
    'https://images.unsplash.com/photo-1603302576837-37561b2e2302?w=800&auto=format&fit=crop&q=80'
  ];

  return (
    <div className="space-y-4">
      {/* Main Image Display */}
      <div className="relative aspect-4/3 rounded-2xl overflow-hidden bg-white border border-slate-200 flex items-center justify-center p-4 shadow-xs">
        <img
          src={displayImages[activeIdx]}
          alt={productName}
          className="w-full h-full object-contain transition-all duration-300"
        />
      </div>

      {/* Thumbnails Row */}
      {displayImages.length > 1 && (
        <div className="flex items-center gap-3 overflow-x-auto pb-1">
          {displayImages.map((img, idx) => (
            <button
              key={idx}
              type="button"
              onClick={() => setActiveIdx(idx)}
              className={`w-20 h-20 rounded-xl overflow-hidden bg-white border-2 shrink-0 p-1.5 transition-all cursor-pointer ${
                activeIdx === idx
                  ? 'border-blue-600 ring-2 ring-blue-600/20'
                  : 'border-slate-200 hover:border-slate-300 opacity-70 hover:opacity-100'
              }`}
            >
              <img
                src={img}
                alt={`Thumbnail ${idx + 1}`}
                className="w-full h-full object-contain"
              />
            </button>
          ))}
        </div>
      )}
    </div>
  );
};
