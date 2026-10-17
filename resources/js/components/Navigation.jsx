import React, { useState, useRef, useEffect } from 'react';
import { 
  LayoutGrid, ChevronDown, Laptop, Gamepad2, Monitor, Cpu, 
  Tv, Headphones, ChevronRight, X, Phone, MapPin, Sparkles
} from 'lucide-react';
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

export const Navigation = ({ mobileMenuOpen, onCloseMobileMenu }) => {
  const { t, activePage, navigateTo, lang } = useShop();
  const [categoriesOpen, setCategoriesOpen] = useState(false);
  const dropdownRef = useRef(null);

  // Close dropdown on outside click
  useEffect(() => {
    function handleClickOutside(event) {
      if (dropdownRef.current && !dropdownRef.current.contains(event.target)) {
        setCategoriesOpen(false);
      }
    }
    document.addEventListener('mousedown', handleClickOutside);
    return () => document.removeEventListener('mousedown', handleClickOutside);
  }, []);

  const navLinks = [
    { id: 'home', label: t.nav.home },
    { id: 'laptops', label: t.nav.laptops, category: 'laptops' },
    { id: 'gaming-laptops', label: t.nav.gamingLaptops, category: 'gaming-laptops' },
    { id: 'desktop-pc', label: t.nav.desktopPcs, category: 'desktop-pc' },
    { id: 'pc-components', label: t.nav.pcParts, category: 'pc-components' },
    { id: 'shop', label: t.nav.fullShop },
    { id: 'track', label: t.nav.trackOrder },
  ];

  const handleNavClick = (link) => {
    if (link.category) {
      navigateTo('category', { category: link.category });
    } else {
      navigateTo(link.id);
    }
    setCategoriesOpen(false);
    onCloseMobileMenu?.();
  };

  const handleCategorySelect = (slug) => {
    navigateTo('category', { category: slug });
    setCategoriesOpen(false);
    onCloseMobileMenu?.();
  };

  return (
    <>
      {/* Desktop Main Navigation Bar */}
      <nav className="hidden lg:block bg-white border-b border-slate-200">
        <div className="max-w-7xl mx-auto px-4 flex items-center justify-between">
          <div className="flex items-center gap-1">
            {/* "All Categories" Prominent Button */}
            <div className="relative py-2 mr-2" ref={dropdownRef}>
              <button
                type="button"
                onClick={() => setCategoriesOpen(!categoriesOpen)}
                className={`flex items-center gap-2.5 px-4 py-2.5 rounded-lg text-sm font-semibold transition-all cursor-pointer ${
                  categoriesOpen
                    ? 'bg-blue-600 text-white shadow-sm'
                    : 'bg-slate-100 hover:bg-slate-200 text-slate-800'
                }`}
              >
                <LayoutGrid className="w-4 h-4" />
                <span>{t.nav.allCategories}</span>
                <ChevronDown className={`w-4 h-4 transition-transform duration-200 ${categoriesOpen ? 'rotate-180' : ''}`} />
              </button>

              {/* Categories Dropdown Menu */}
              {categoriesOpen && (
                <div className="absolute top-full left-0 mt-1 w-72 bg-white border border-slate-200 rounded-xl shadow-xl z-50 py-2 animate-in fade-in slide-in-from-top-1 duration-150">
                  <div className="px-3 py-1.5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                    {lang === 'km' ? 'បញ្ជីផ្នែកផលិតផល' : 'Product Departments'}
                  </div>
                  {categoriesData.map(cat => {
                    const IconComponent = iconMap[cat.icon] || Laptop;
                    return (
                      <button
                        key={cat.id}
                        onClick={() => handleCategorySelect(cat.slug)}
                        className="w-full flex items-center justify-between px-3.5 py-2.5 hover:bg-blue-50 text-slate-700 hover:text-blue-600 text-sm font-medium transition-colors text-left group cursor-pointer"
                      >
                        <div className="flex items-center gap-3">
                          <div className="w-8 h-8 rounded-lg bg-slate-100 group-hover:bg-blue-100 text-slate-600 group-hover:text-blue-600 flex items-center justify-center transition-colors">
                            <IconComponent className="w-4 h-4" />
                          </div>
                          <div>
                            <div className="leading-tight font-medium">
                              {lang === 'km' ? cat.name_km : cat.name}
                            </div>
                            <div className="text-[11px] text-slate-400 font-normal">
                              {cat.count} {t.categories.itemsCount}
                            </div>
                          </div>
                        </div>
                        <ChevronRight className="w-4 h-4 text-slate-300 group-hover:text-blue-600 transition-colors" />
                      </button>
                    );
                  })}
                </div>
              )}
            </div>

            {/* Nav Menu Links */}
            {navLinks.map((link) => {
              const isActive = activePage === link.id || (link.category && activePage === 'category');
              return (
                <button
                  key={link.id}
                  onClick={() => handleNavClick(link)}
                  className={`px-3.5 py-4 text-sm font-medium transition-colors border-b-2 cursor-pointer ${
                    isActive
                      ? 'border-blue-600 text-blue-600 font-semibold'
                      : 'border-transparent text-slate-600 hover:text-blue-600 hover:border-slate-300'
                  }`}
                >
                  {link.label}
                </button>
              );
            })}
          </div>

          {/* Right Promotion Pill */}
          <div className="flex items-center gap-2 text-xs font-semibold text-blue-700 bg-blue-50/80 px-3 py-1.5 rounded-full border border-blue-200/50">
            <Sparkles className="w-3.5 h-3.5 text-blue-600" />
            <span>{lang === 'km' ? 'បញ្ចុះតម្លៃពិសេសប្រចាំខែ' : 'Official Warranty in Cambodia'}</span>
          </div>
        </div>
      </nav>

      {/* Mobile Drawer Navigation */}
      {mobileMenuOpen && (
        <div className="fixed inset-0 z-50 lg:hidden flex">
          {/* Backdrop */}
          <div
            className="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity"
            onClick={onCloseMobileMenu}
          />

          {/* Drawer content */}
          <div className="relative w-full max-w-xs bg-white h-full shadow-2xl flex flex-col z-10 overflow-y-auto">
            {/* Drawer Header */}
            <div className="p-4 border-b border-slate-200 flex items-center justify-between bg-slate-50">
              <div className="flex items-center gap-2">
                <div className="w-8 h-8 rounded-lg bg-blue-600 text-white flex items-center justify-center font-bold text-sm">
                  QT
                </div>
                <div className="font-bold text-slate-900 text-base">QuickTech KH</div>
              </div>
              <button
                onClick={onCloseMobileMenu}
                className="p-1.5 text-slate-400 hover:text-slate-700 hover:bg-slate-200/60 rounded-lg cursor-pointer"
              >
                <X className="w-5 h-5" />
              </button>
            </div>

            {/* Navigation links */}
            <div className="p-3 space-y-1">
              <div className="text-[11px] font-bold text-slate-400 uppercase tracking-wider px-3 py-1">
                Navigation
              </div>
              {navLinks.map((link) => (
                <button
                  key={link.id}
                  onClick={() => handleNavClick(link)}
                  className="w-full text-left px-3 py-2.5 rounded-lg text-sm font-medium text-slate-800 hover:bg-blue-50 hover:text-blue-600 transition-colors flex items-center justify-between cursor-pointer"
                >
                  <span>{link.label}</span>
                  <ChevronRight className="w-4 h-4 text-slate-400" />
                </button>
              ))}
            </div>

            {/* Expandable Categories */}
            <div className="p-3 border-t border-slate-200">
              <div className="text-[11px] font-bold text-slate-400 uppercase tracking-wider px-3 py-1 mb-1">
                {t.categories.title}
              </div>
              <div className="space-y-1">
                {categoriesData.map(cat => {
                  const IconComponent = iconMap[cat.icon] || Laptop;
                  return (
                    <button
                      key={cat.id}
                      onClick={() => handleCategorySelect(cat.slug)}
                      className="w-full flex items-center justify-between px-3 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition-colors cursor-pointer"
                    >
                      <div className="flex items-center gap-2.5">
                        <IconComponent className="w-4 h-4 text-blue-600" />
                        <span>{lang === 'km' ? cat.name_km : cat.name}</span>
                      </div>
                      <span className="text-xs text-slate-400">{cat.count}</span>
                    </button>
                  );
                })}
              </div>
            </div>

            {/* Contact info bottom */}
            <div className="mt-auto p-4 bg-slate-50 border-t border-slate-200 text-xs text-slate-600 space-y-2">
              <div className="flex items-center gap-2 text-slate-700 font-semibold">
                <Phone className="w-4 h-4 text-blue-600" />
                <span>+855 11 444 888 / +855 96 444 888</span>
              </div>
              <div className="flex items-center gap-2 text-slate-500">
                <MapPin className="w-4 h-4 text-blue-600 shrink-0" />
                <span>Street 271, Phnom Penh, Cambodia</span>
              </div>
            </div>
          </div>
        </div>
      )}
    </>
  );
};
