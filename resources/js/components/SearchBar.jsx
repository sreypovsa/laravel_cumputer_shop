import React, { useState, useRef, useEffect } from 'react';
import { Search, X, TrendingUp, History, Laptop, ChevronRight } from 'lucide-react';
import { useShop } from '../context/ShopContext';
import { productsData, categoriesData } from '../data/mockData';

export const SearchBar = () => {
  const { t, navigateTo, setSearchQuery, searchQuery } = useShop();
  const [isOpen, setIsOpen] = useState(false);
  const [query, setQuery] = useState(searchQuery || '');
  const [recentSearches, setRecentSearches] = useState([
    'RTX 4070', 'ROG Strix', 'Lenovo Legion', 'i7 13700F'
  ]);
  const wrapperRef = useRef(null);

  const popularSearches = [
    'ASUS ROG', 'Gaming Laptop', 'RTX 4060', 'MacBook M3', 'DDR5 16GB', 'Samsung NVMe'
  ];

  // Filter products for suggestions
  const suggestions = query.trim().length > 1
    ? productsData.filter(p =>
        p.name.toLowerCase().includes(query.toLowerCase()) ||
        p.brand.toLowerCase().includes(query.toLowerCase()) ||
        p.specs.cpu.toLowerCase().includes(query.toLowerCase()) ||
        p.specs.gpu.toLowerCase().includes(query.toLowerCase())
      ).slice(0, 5)
    : [];

  // Close on outside click
  useEffect(() => {
    function handleClickOutside(event) {
      if (wrapperRef.current && !wrapperRef.current.contains(event.target)) {
        setIsOpen(false);
      }
    }
    document.addEventListener('mousedown', handleClickOutside);
    return () => document.removeEventListener('mousedown', handleClickOutside);
  }, []);

  const handleSearchSubmit = (e) => {
    e?.preventDefault();
    if (!query.trim()) return;

    if (!recentSearches.includes(query.trim())) {
      setRecentSearches(prev => [query.trim(), ...prev.slice(0, 4)]);
    }

    setIsOpen(false);
    setSearchQuery(query.trim());
    navigateTo('shop', { search: query.trim() });
  };

  const handleSelectRecent = (term) => {
    setQuery(term);
    setSearchQuery(term);
    setIsOpen(false);
    navigateTo('shop', { search: term });
  };

  const handleSelectProduct = (product) => {
    setIsOpen(false);
    navigateTo('product-detail', { product });
  };

  const handleClear = () => {
    setQuery('');
    setSearchQuery('');
  };

  return (
    <div ref={wrapperRef} className="relative w-full max-w-2xl">
      <form onSubmit={handleSearchSubmit} className="relative flex items-center">
        <div className="absolute left-3.5 text-slate-400 pointer-events-none">
          <Search className="w-4 h-4" />
        </div>

        <input
          type="text"
          value={query}
          onChange={(e) => {
            setQuery(e.target.value);
            setIsOpen(true);
          }}
          onFocus={() => setIsOpen(true)}
          placeholder={t.header.searchPlaceholder}
          className="w-full pl-10 pr-24 py-2.5 bg-slate-50 border border-slate-300 rounded-lg text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 focus:bg-white transition-all shadow-xs"
        />

        {query && (
          <button
            type="button"
            onClick={handleClear}
            className="absolute right-20 text-slate-400 hover:text-slate-600 p-1 cursor-pointer"
          >
            <X className="w-3.5 h-3.5" />
          </button>
        )}

        <button
          type="submit"
          className="absolute right-1 top-1 bottom-1 px-4 bg-blue-600 hover:bg-blue-700 text-white rounded-md text-xs font-semibold tracking-wide transition-colors flex items-center gap-1 cursor-pointer"
        >
          <Search className="w-3.5 h-3.5" />
          <span className="hidden sm:inline">Search</span>
        </button>
      </form>

      {/* Suggestion Dropdown */}
      {isOpen && (
        <div className="absolute top-full left-0 right-0 mt-1.5 bg-white border border-slate-200 rounded-xl shadow-xl z-50 overflow-hidden divide-y divide-slate-100 animate-in fade-in slide-in-from-top-1 duration-150">
          {/* Live Matching Products */}
          {suggestions.length > 0 && (
            <div className="p-3">
              <div className="text-[11px] font-semibold text-slate-400 uppercase tracking-wider px-2 mb-2">
                Products Matching "{query}"
              </div>
              <div className="space-y-1">
                {suggestions.map(p => (
                  <button
                    key={p.id}
                    onClick={() => handleSelectProduct(p)}
                    className="w-full flex items-center justify-between p-2 rounded-lg hover:bg-slate-50 transition-colors text-left group cursor-pointer"
                  >
                    <div className="flex items-center gap-3">
                      <img
                        src={p.image}
                        alt={p.name}
                        className="w-10 h-10 object-cover rounded-md border border-slate-200"
                      />
                      <div>
                        <div className="text-sm font-medium text-slate-900 group-hover:text-blue-600 transition-colors line-clamp-1">
                          {p.name}
                        </div>
                        <div className="text-xs text-slate-500 flex items-center gap-2">
                          <span className="font-semibold text-blue-600">${p.price.toFixed(2)}</span>
                          <span>•</span>
                          <span>{p.brand}</span>
                          <span>•</span>
                          <span className="line-clamp-1">{p.specs.cpu}</span>
                        </div>
                      </div>
                    </div>
                    <ChevronRight className="w-4 h-4 text-slate-300 group-hover:text-blue-600 transition-colors" />
                  </button>
                ))}
              </div>
            </div>
          )}

          {/* Recent Searches */}
          {recentSearches.length > 0 && (
            <div className="p-3 bg-slate-50/50">
              <div className="flex items-center justify-between px-2 mb-2">
                <span className="text-[11px] font-semibold text-slate-400 uppercase tracking-wider flex items-center gap-1.5">
                  <History className="w-3 h-3" />
                  {t.header.recentSearches}
                </span>
                <button
                  type="button"
                  onClick={() => setRecentSearches([])}
                  className="text-[11px] text-blue-600 hover:underline cursor-pointer"
                >
                  {t.header.clear}
                </button>
              </div>
              <div className="flex flex-wrap gap-1.5">
                {recentSearches.map((term, i) => (
                  <button
                    key={i}
                    onClick={() => handleSelectRecent(term)}
                    className="text-xs px-2.5 py-1 bg-white border border-slate-200 rounded-md text-slate-700 hover:border-blue-500 hover:text-blue-600 transition-colors cursor-pointer"
                  >
                    {term}
                  </button>
                ))}
              </div>
            </div>
          )}

          {/* Popular Searches */}
          <div className="p-3">
            <span className="text-[11px] font-semibold text-slate-400 uppercase tracking-wider flex items-center gap-1.5 px-2 mb-2">
              <TrendingUp className="w-3 h-3 text-amber-500" />
              {t.header.popularSearches}
            </span>
            <div className="flex flex-wrap gap-1.5">
              {popularSearches.map((term, i) => (
                <button
                  key={i}
                  onClick={() => handleSelectRecent(term)}
                  className="text-xs px-2.5 py-1 bg-slate-100 hover:bg-blue-50 hover:text-blue-600 rounded-md text-slate-600 transition-colors cursor-pointer"
                >
                  {term}
                </button>
              ))}
            </div>
          </div>

          {/* Full Search Action */}
          {query.trim() && (
            <button
              onClick={handleSearchSubmit}
              className="w-full p-2.5 text-center text-xs font-semibold text-blue-600 hover:bg-blue-50 transition-colors flex items-center justify-center gap-1 cursor-pointer"
            >
              <span>{t.header.viewAllResults} "{query}"</span>
              <ChevronRight className="w-3.5 h-3.5" />
            </button>
          )}
        </div>
      )}
    </div>
  );
};
