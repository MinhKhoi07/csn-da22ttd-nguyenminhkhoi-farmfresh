import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Add-to-cart with modal preview and fly-to-cart animation
document.addEventListener('DOMContentLoaded', () => {
  const cartIcon = document.getElementById('cartIcon');
  const badge = document.getElementById('cartCountBadge');
  const modal = document.getElementById('productModal');
  const modalImage = document.getElementById('modalImage')?.querySelector('img');
  const modalProductName = document.getElementById('modalProductName');
  const modalProductPrice = document.getElementById('modalProductPrice');
  const modalProductUnit = document.getElementById('modalProductUnit');
  const modalQuantity = document.getElementById('modalQuantity');
  const modalTotal = document.getElementById('modalTotal');
  const closeModalBtn = document.getElementById('closeModal');
  const cancelModalBtn = document.getElementById('cancelModal');
  const confirmBtn = document.getElementById('confirmAddToCart');
  const decreaseBtn = document.getElementById('decreaseQty');
  const increaseBtn = document.getElementById('increaseQty');

  const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

  let currentForm = null;
  let currentProductData = null;

  function showToast(message, isError = false) {
    const toast = document.createElement('div');
    toast.textContent = message || '';
    toast.style.position = 'fixed';
    toast.style.bottom = '20px';
    toast.style.left = '50%';
    toast.style.transform = 'translateX(-50%)';
    toast.style.padding = '10px 16px';
    toast.style.borderRadius = '12px';
    toast.style.fontWeight = '600';
    toast.style.zIndex = '9999';
    toast.style.background = isError ? '#fee2e2' : '#ecfdf5';
    toast.style.color = isError ? '#991b1b' : '#065f46';
    toast.style.border = '1px solid ' + (isError ? '#fecaca' : '#d1fae5');
    document.body.appendChild(toast);
    setTimeout(() => {
      toast.style.opacity = '0';
      toast.style.transition = 'opacity 300ms ease';
      setTimeout(() => toast.remove(), 300);
    }, 1500);
  }

  function flyToCart(sourceEl, targetEl) {
    if (!targetEl) return;

    const cartRect = targetEl.getBoundingClientRect();
    const srcRect = sourceEl?.getBoundingClientRect?.() || { left: window.innerWidth/2, top: window.innerHeight/2, width: 40, height: 40 };

    let clone;
    if (sourceEl && sourceEl.tagName === 'IMG') {
      clone = sourceEl.cloneNode(true);
      clone.style.width = srcRect.width + 'px';
      clone.style.height = srcRect.height + 'px';
      clone.style.borderRadius = '12px';
    } else {
      clone = document.createElement('div');
      clone.textContent = '🥦';
      clone.style.display = 'flex';
      clone.style.alignItems = 'center';
      clone.style.justifyContent = 'center';
      clone.style.fontSize = '24px';
      clone.style.width = '40px';
      clone.style.height = '40px';
      clone.style.borderRadius = '9999px';
      clone.style.background = '#ecfdf5';
      clone.style.border = '1px solid #d1fae5';
      clone.style.boxShadow = '0 10px 20px rgba(16,185,129,0.25)';
    }

    clone.style.position = 'fixed';
    clone.style.pointerEvents = 'none';
    clone.style.left = srcRect.left + 'px';
    clone.style.top = srcRect.top + 'px';
    clone.style.zIndex = '9998';
    clone.style.transition = 'transform 700ms ease, opacity 700ms ease';
    document.body.appendChild(clone);

    const translateX = cartRect.left + cartRect.width / 2 - (srcRect.left + srcRect.width / 2);
    const translateY = cartRect.top + cartRect.height / 2 - (srcRect.top + srcRect.height / 2);

    requestAnimationFrame(() => {
      clone.style.transform = `translate(${translateX}px, ${translateY}px) scale(0.2)`;
      clone.style.opacity = '0.25';
    });

    // cartIcon small bounce
    targetEl.style.transition = 'transform 200ms ease';
    targetEl.style.transform = 'scale(1.15)';
    setTimeout(() => { targetEl.style.transform = 'scale(1)'; }, 220);

    setTimeout(() => clone.remove(), 800);
  }

  function updateModalTotal() {
    if (!currentProductData || !modalTotal || !modalQuantity) return;
    const price = parseFloat(currentProductData.price) || 0;
    const qty = parseInt(modalQuantity.value) || 1;
    const total = price * qty;
    modalTotal.textContent = total.toLocaleString('vi-VN') + 'đ';
  }

  function showModal(productData, form) {
    if (!modal) return;
    currentForm = form;
    currentProductData = productData;

    if (modalImage) modalImage.src = productData.image || '';
    if (modalProductName) modalProductName.textContent = productData.name || '';
    if (modalProductPrice) modalProductPrice.textContent = productData.priceFormatted || '';
    if (modalProductUnit) modalProductUnit.textContent = '/' + (productData.unit || 'kg');
    if (modalQuantity) modalQuantity.value = '1';

    updateModalTotal();
    modal.classList.remove('hidden');
  }

  function hideModal() {
    if (!modal) return;
    modal.classList.add('hidden');
    currentForm = null;
    currentProductData = null;
  }

  // Modal controls
  if (closeModalBtn) closeModalBtn.addEventListener('click', hideModal);
  if (cancelModalBtn) cancelModalBtn.addEventListener('click', hideModal);
  if (modal) {
    modal.addEventListener('click', (e) => {
      if (e.target === modal) hideModal();
    });
  }

  if (decreaseBtn && modalQuantity) {
    decreaseBtn.addEventListener('click', () => {
      const current = parseInt(modalQuantity.value) || 1;
      if (current > 1) {
        modalQuantity.value = current - 1;
        updateModalTotal();
      }
    });
  }

  if (increaseBtn && modalQuantity) {
    increaseBtn.addEventListener('click', () => {
      const current = parseInt(modalQuantity.value) || 1;
      modalQuantity.value = current + 1;
      updateModalTotal();
    });
  }

  if (modalQuantity) {
    modalQuantity.addEventListener('input', () => {
      const val = parseInt(modalQuantity.value) || 1;
      if (val < 1) modalQuantity.value = 1;
      updateModalTotal();
    });
  }

  // Confirm add to cart from modal
  if (confirmBtn) {
    confirmBtn.addEventListener('click', async () => {
      if (!currentForm || !currentProductData) return;

      const quantity = parseInt(modalQuantity.value) || 1;
      // Cache references BEFORE hiding modal (hideModal clears state)
      const formRef = currentForm;
      const url = formRef ? formRef.action : '';
      const cardRef = formRef ? formRef.closest('.product-card') : null;
      const imgRef = cardRef ? cardRef.querySelector('img') : modalImage;

      hideModal();

      if (!url) {
        showToast('Không xác định được URL thêm vào giỏ', true);
        return;
      }

      try {
        const resp = await fetch(url, {
          method: 'POST',
          headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': csrfToken,
          },
          body: JSON.stringify({ quantity }),
        });

        // If unauthenticated (401)
        if (resp.status === 401) {
          const json = await resp.json().catch(() => null);
          const loginUrl = json?.redirect || '/login';
          showToast(json?.message || 'Vui lòng đăng nhập', true);
          setTimeout(() => { window.location.href = loginUrl; }, 800);
          return;
        }

        if (resp.ok) {
          // Animation only on success
          flyToCart(imgRef, cartIcon);

          const json = await resp.json().catch(() => null);
          if (json && typeof json.cartCount !== 'undefined' && badge) {
            badge.textContent = json.cartCount;
          }
          showToast(json?.message || 'Đã thêm vào giỏ hàng');
        } else {
          console.error('Response not OK:', resp.status, resp.statusText);
          const errorText = await resp.text().catch(() => 'Unknown error');
          console.error('Error response:', errorText);
          showToast('Có lỗi khi thêm vào giỏ hàng', true);
        }
      } catch (err) {
        console.error('Fetch error:', err);
        showToast('Có lỗi khi thêm vào giỏ hàng', true);
      }
    });
  }

  // Intercept add-to-cart forms to show modal
  document.querySelectorAll('.js-add-to-cart-form').forEach((form) => {
    form.addEventListener('submit', (e) => {
      e.preventDefault();

      const card = form.closest('.product-card');
      if (!card) return;

      const productData = {
        id: card.dataset.productId || '',
        name: card.dataset.productName || '',
        priceFormatted: card.dataset.productPrice || '',
        price: card.dataset.price || '0',
        unit: card.dataset.productUnit || 'kg',
        image: card.dataset.image || '',
      };

      showModal(productData, form);
    });
  });

  // Favorite toggle
  document.querySelectorAll('.js-fav-btn').forEach((btn) => {
    btn.addEventListener('click', async (e) => {
      e.preventDefault();
      const pid = btn.getAttribute('data-product-id');
      if (!pid) return;

      try {
        const resp = await fetch(`/favorites/toggle/${pid}`, {
          method: 'POST',
          headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': csrfToken,
          },
        });

        if (resp.status === 401) {
          const json = await resp.json().catch(() => null);
          const loginUrl = json?.redirect || '/login';
          showToast(json?.message || 'Vui lòng đăng nhập', true);
          setTimeout(() => { window.location.href = loginUrl; }, 800);
          return;
        }

        if (resp.ok) {
          const json = await resp.json().catch(() => null);
          const isActive = !!json?.favorited;
          btn.classList.toggle('text-red-500', isActive);
          btn.classList.toggle('text-gray-400', !isActive);
          btn.setAttribute('aria-pressed', isActive ? 'true' : 'false');
          showToast(isActive ? 'Đã thêm vào yêu thích' : 'Đã bỏ yêu thích');
        } else {
          showToast('Không thể cập nhật yêu thích', true);
        }
      } catch (err) {
        showToast('Không thể cập nhật yêu thích', true);
      }
    });
  });
});
