import React from 'react';
import { ChevronRight } from 'lucide-react';
import { ProductCard } from './ProductCard';
import { useShop } from '../context/ShopContext';

export const ProductGrid = ({ 
  title, 
  subtitle, 
  products, 
  onExplore, 
  exploreLabel, 
  columns = '4' 
}) => {
  const { t } = useShop();

  const gridColsClass = {
    '4': 'grid-cols-2 md:grid-cols-3 lg:grid-cols-4',
    '3': 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-3',
    '6': 'grid-cols-2 md:grid-cols-3 lg:grid-cols-6',
  }[columns] || 'grid-cols-2 md:grid-cols-3 lg:grid-cols-4';

  return (
    <section className="py-10">
      <div className="max-w-7xl mx-auto px-4">
        {/* Section Header */}
        {(title || subtitle) && (
          <div className="flex flex-col sm:flex-row sm:items-end justify-between mb-8 gap-4">
            <div>
              {title && (
                <h2 className="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900">
                  {title}
                </h2>
              )}
              {subtitle && (
                <p className="text-sm text-slate-500 mt-1">
                  {subtitle}
                </p>
              )}
            </div>
            {onExplore && (
              <button
                onClick={onExplore}
                className="inline-flex items-center gap-1.5 text-sm font-semibold text-blue-600 hover:text-blue-700 cursor-pointer self-start sm:self-auto"
              >
                <span>{exploreLabel || t.categories.viewAll}</span>
                <ChevronRight className="w-4 h-4" />
              </button>
            )}
          </div>
        )}

        {/* Product Cards Grid */}
        <div className={`grid ${gridColsClass} gap-4 sm:gap-6`}>
          {products.map((product) => (
            <ProductCard key={product.id} product={product} />
          ))}
        </div>
      </div>
    </section>
  );
};
