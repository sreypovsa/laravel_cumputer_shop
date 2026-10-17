import React from 'react';
import { CheckCircle2, AlertCircle, Info, X } from 'lucide-react';
import { useShop } from '../context/ShopContext';

export const ToastContainer = () => {
  const { toasts, removeToast } = useShop();

  if (toasts.length === 0) return null;

  return (
    <div className="fixed bottom-5 right-5 z-50 flex flex-col gap-2 max-w-sm w-full pointer-events-none px-4 sm:px-0">
      {toasts.map((toast) => {
        const isSuccess = toast.type === 'success';
        const isError = toast.type === 'error';
        const Icon = isSuccess ? CheckCircle2 : isError ? AlertCircle : Info;

        return (
          <div
            key={toast.id}
            className={`pointer-events-auto flex items-start gap-3 p-3.5 rounded-xl border shadow-lg backdrop-blur-md animate-in slide-in-from-bottom-2 duration-200 ${
              isSuccess
                ? 'bg-slate-900/95 border-emerald-500/40 text-white'
                : isError
                ? 'bg-red-950/95 border-red-500/40 text-white'
                : 'bg-slate-900/95 border-blue-500/40 text-white'
            }`}
          >
            <Icon
              className={`w-5 h-5 shrink-0 mt-0.5 ${
                isSuccess
                  ? 'text-emerald-400'
                  : isError
                  ? 'text-red-400'
                  : 'text-blue-400'
              }`}
            />
            <div className="flex-1 min-w-0">
              <div className="text-xs font-bold leading-tight">
                {toast.title}
              </div>
              {toast.message && (
                <div className="text-[11px] text-slate-300 mt-0.5 line-clamp-2">
                  {toast.message}
                </div>
              )}
            </div>
            <button
              onClick={() => removeToast(toast.id)}
              className="text-slate-400 hover:text-white p-0.5 cursor-pointer shrink-0"
            >
              <X className="w-3.5 h-3.5" />
            </button>
          </div>
        );
      })}
    </div>
  );
};
