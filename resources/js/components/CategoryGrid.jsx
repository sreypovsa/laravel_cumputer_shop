import React from 'react';
import { Laptop, Gamepad2, Monitor, Cpu, Tv, Headphones, ChevronRight } from 'lucide-react';
import { useShop } from '../context/ShopContext';
import { categoriesData } from '../data/mockData';

const iconMap = {
  Laptop: Laptop,
  Gamepad2: Gamepad2,
  Monitor: Monitor,
  Cpu: Cpu,
  Tv: Tv,
  Headphones: Headphones,
};

export const CategoryGrid = () => {
  const { t, navigateTo, lang } = useShop();

  const handleCategoryClick = (slug) => {
    navigateTo('category', { category: slug });
  };

  return (
    <section className="py-12 bg-[#F8FAFC]">
      <div className="max-w-7xl mx-auto px-4">
        {/* Section Header */}
        <div className="flex flex-col sm:flex-row sm:items-end justify-between mb-8 gap-4">
          <div>
            <h2 className="text-2xl sm:text-3xl font-bold tracking-tight text-slate-900">
              {t.categories.title}
            </h2>
            <p className="text-sm text-slate-500 mt-1">
              {t.categories.subtitle}
            </p>
          </div>
          <button
            onClick={() => navigateTo('shop')}
            className="inline-flex items-center gap-1.5 text-sm font-semibold text-blue-600 hover:text-blue-700 cursor-pointer self-start sm:self-auto"
          >
            <span>{t.categories.viewAll}</span>
            <ChevronRight className="w-4 h-4" />
          </button>
        </div>

        {/* 6 Columns Grid on Desktop, 3 on Tablet, 2 on Mobile */}
        <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4">
          {categoriesData.map((cat) => {
            const Icon = iconMap[cat.icon] || Laptop;
            return (
              <button
                key={cat.id}
                onClick={() => handleCategoryClick(cat.slug)}
                className="group relative bg-white border border-slate-200 hover:border-blue-600 rounded-2xl p-4 flex flex-col items-center text-center transition-all duration-200 hover:-translate-y-1 hover:shadow-md cursor-pointer overflow-hidden"
              >
                {/* Category Thumbnail Container */}
                <div className="w-20 h-20 sm:w-24 sm:h-24 mb-3 rounded-xl overflow-hidden bg-slate-50 flex items-center justify-center p-2">
                  <img
                    src={cat.image}
                    alt={cat.name}
                    className="w-full h-full object-cover rounded-lg group-hover:scale-108 transition-transform duration-300"
                    loading="lazy"
                  />
                </div>

                {/* Category Icon Badge */}
                <div className="w-7 h-7 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center -mt-6 mb-2 border-2 border-white shadow-xs">
                  <Icon className="w-3.5 h-3.5" />
                </div>

                {/* Category Name */}
                <h3 className="text-xs sm:text-sm font-bold text-slate-900 group-hover:text-blue-600 transition-colors line-clamp-2 leading-snug">
                  {lang === 'km' ? cat.name_km : cat.name}
                </h3>

                {/* Product Count */}
                <span className="text-[11px] text-slate-400 mt-1 font-medium">
                  {cat.count} {t.categories.itemsCount}
                </span>
              </button>
            );
          })}
        </div>
      </div>
    </section>
  );
};
