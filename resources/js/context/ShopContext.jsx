import React, { createContext, useContext, useState, useEffect } from 'react';
import { translations } from '../data/translations';
import { productsData, categoriesData } from '../data/mockData';

const ShopContext = createContext();

export const ShopProvider = ({ children }) => {
  const [lang, setLang] = useState('en');
  const [activePage, setActivePage] = useState('home');
  const [selectedProduct, setSelectedProduct] = useState(null);
  const [selectedCategory, setSelectedCategory] = useState(null);
  const [searchQuery, setSearchQuery] = useState('');
  
  // Cart state
  const [cart, setCart] = useState(() => {
    try {
      const saved = localStorage.getItem('quicktech_cart');
      return saved ? JSON.parse(saved) : [
        { product: productsData[0], quantity: 1 }
      ];
    } catch {
      return [{ product: productsData[0], quantity: 1 }];
    }
  });

  // Wishlist state
  const [wishlist, setWishlist] = useState(() => {
    try {
      const saved = localStorage.getItem('quicktech_wishlist');
      return saved ? JSON.parse(saved) : ['asus-rog-strix-g16'];
    } catch {
      return ['asus-rog-strix-g16'];
    }
  });

  // Quick View Modal
  const [quickViewProduct, setQuickViewProduct] = useState(null);
  const [isCartOpen, setIsCartOpen] = useState(false);

  // Toasts
  const [toasts, setToasts] = useState([]);

  useEffect(() => {
    try {
      localStorage.setItem('quicktech_cart', JSON.stringify(cart));
    } catch (e) {
      console.error(e);
    }
  }, [cart]);

  useEffect(() => {
    try {
      localStorage.setItem('quicktech_wishlist', JSON.stringify(wishlist));
    } catch (e) {
      console.error(e);
    }
  }, [wishlist]);

  // Scroll to top on page navigation
  useEffect(() => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }, [activePage, selectedProduct]);

  const addToast = (title, message, type = 'success') => {
    const id = Date.now() + Math.random();
    setToasts(prev => [...prev, { id, title, message, type }]);
    setTimeout(() => {
      setToasts(prev => prev.filter(t => t.id !== id));
    }, 3500);
  };

  const removeToast = (id) => {
    setToasts(prev => prev.filter(t => t.id !== id));
  };

  const toggleLang = () => {
    const nextLang = lang === 'en' ? 'km' : 'en';
    setLang(nextLang);
    addToast(
      nextLang === 'en' ? 'Language Switched' : 'បានប្តូរភាសា',
      nextLang === 'en' ? 'Switched to English' : 'បានប្តូរទៅជាភាសាខ្មែរ',
      'info'
    );
  };

  const t = translations[lang] || translations.en;

  const addToCart = (product, quantity = 1, showDrawer = true) => {
    setCart(prev => {
      const existing = prev.find(item => item.product.id === product.id);
      if (existing) {
        return prev.map(item =>
          item.product.id === product.id
            ? { ...item, quantity: item.quantity + quantity }
            : item
        );
      }
      return [...prev, { product, quantity }];
    });

    addToast(
      lang === 'en' ? 'Added to Cart' : 'បានដាក់ក្នុងកន្ត្រក',
      `${product.name} (${quantity}x)`
    );

    if (showDrawer) {
      setIsCartOpen(true);
    }
  };

  const updateQuantity = (productId, delta) => {
    setCart(prev =>
      prev
        .map(item => {
          if (item.product.id === productId) {
            const newQty = item.quantity + delta;
            return newQty > 0 ? { ...item, quantity: newQty } : null;
          }
          return item;
        })
        .filter(Boolean)
    );
  };

  const removeFromCart = (productId) => {
    setCart(prev => prev.filter(item => item.product.id !== productId));
    addToast(
      lang === 'en' ? 'Removed' : 'បានលុបចេញ',
      lang === 'en' ? 'Item removed from your cart' : 'ផលិតផលត្រូវបានដកចេញពីកន្ត្រក',
      'info'
    );
  };

  const clearCart = () => {
    setCart([]);
  };

  const toggleWishlist = (product) => {
    const isWishlisted = wishlist.includes(product.id);
    if (isWishlisted) {
      setWishlist(prev => prev.filter(id => id !== product.id));
      addToast(
        lang === 'en' ? 'Removed from Wishlist' : 'បានដកចេញពីបញ្ជីពេញចិត្ត',
        product.name,
        'info'
      );
    } else {
      setWishlist(prev => [...prev, product.id]);
      addToast(
        lang === 'en' ? 'Added to Wishlist' : 'បានបញ្ចូលក្នុងបញ្ជីពេញចិត្ត',
        product.name,
        'success'
      );
    }
  };

  const isInWishlist = (productId) => wishlist.includes(productId);

  const cartCount = cart.reduce((acc, item) => acc + item.quantity, 0);
  const cartSubtotal = cart.reduce(
    (acc, item) => acc + item.product.price * item.quantity,
    0
  );
  const deliveryFee = cartSubtotal >= 100 || cartSubtotal === 0 ? 0 : 2.50;
  const cartTotal = cartSubtotal + deliveryFee;

  const navigateTo = (page, params = {}) => {
    setActivePage(page);
    if (params.product) setSelectedProduct(params.product);
    if (params.category) setSelectedCategory(params.category);
    if (params.search !== undefined) setSearchQuery(params.search);
  };

  return (
    <ShopContext.Provider
      value={{
        lang,
        setLang,
        toggleLang,
        t,
        activePage,
        setActivePage,
        selectedProduct,
        setSelectedProduct,
        selectedCategory,
        setSelectedCategory,
        searchQuery,
        setSearchQuery,
        cart,
        addToCart,
        updateQuantity,
        removeFromCart,
        clearCart,
        cartCount,
        cartSubtotal,
        deliveryFee,
        cartTotal,
        isCartOpen,
        setIsCartOpen,
        wishlist,
        toggleWishlist,
        isInWishlist,
        quickViewProduct,
        setQuickViewProduct,
        toasts,
        addToast,
        removeToast,
        navigateTo,
      }}
    >
      {children}
    </ShopContext.Provider>
  );
};

export const useShop = () => {
  const context = useContext(ShopContext);
  if (!context) {
    throw new Error('useShop must be used within a ShopProvider');
  }
  return context;
};
