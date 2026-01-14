// document.addEventListener('DOMContentLoaded', function () {
//   const thumbs = Array.from(document.querySelectorAll('.js-gallery-thumb'));
//   if (!thumbs.length) return;

//   const modal = document.getElementById('photoModal');
//   const modalInner = modal.querySelector('.photo-modal-inner');
//   const modalImg = document.getElementById('photoModalImg');
//   const btnClose = modal.querySelector('.photo-modal-close');
//   const btnPrev = modal.querySelector('.photo-modal-prev');
//   const btnNext = modal.querySelector('.photo-modal-next');
//   const backdrop = modal.querySelector('.photo-modal-backdrop');

//   const images = thumbs.map(img => img.getAttribute('data-full') || img.src);
//   let currentIndex = 0;
//   let panzoomInstance = null;

//   function destroyPanzoom() {
//     if (panzoomInstance) {
//       try { panzoomInstance.destroy(); } catch (e) {}
//       panzoomInstance = null;
//     }
//     // очистим inline-стили, чтобы не мешали следующему изображению
//     modalImg.style.transform = '';
//     modalImg.style.width = '';
//     modalImg.style.height = '';
//     modalImg.style.position = '';
//     modalInner.style.width = '';
//     modalInner.style.height = '';
//   }

//   function createPanzoomUsingNaturalSize() {
//     destroyPanzoom();

//     const natW = modalImg.naturalWidth || modalImg.width;
//     const natH = modalImg.naturalHeight || modalImg.height;
//     if (!natW || !natH) {
//       // fallback: просто создаём Panzoom без специфики размеров
//       panzoomInstance = Panzoom(modalImg, { maxScale: 6, minScale: 0.3, contain: 'outside' });
//       modalInner.onwheel = panzoomInstance.zoomWithWheel;
//       return;
//     }

//     // вычисляем максимальные границы окна предпросмотра (90vw/90vh)
//     const winMaxW = window.innerWidth * 0.9;
//     const winMaxH = window.innerHeight * 0.9;

//     // подгоняем окно предпросмотра под картинку
//     const frameScale = Math.min(90 * window.innerWidth / 100 / natW,
//                                 90 * window.innerHeight / 100 / natH);

//     modalInner.style.width = (natW * frameScale) + 'px';
//     modalInner.style.height = (natH * frameScale) + 'px';

//     // делаем картинку абсолютной и в натуральных пикселях,
//     // Panzoom будет масштабировать/панить этот элемент
//     modalImg.style.position = 'absolute';
//     modalImg.style.left = '0px';
//     modalImg.style.top = '0px';
//     modalImg.style.width = natW + 'px';
//     modalImg.style.height = natH + 'px';
//     modalImg.style.maxWidth = 'none';
//     modalImg.style.maxHeight = 'none';
//     modalImg.style.objectFit = 'none';
//     modalImg.style.transformOrigin = '0 0';

//     panzoomInstance = Panzoom(modalImg, {
//       maxScale: 8,
//       minScale: 0.2,
//       contain: 'outside'
//     });
//     modalInner.onwheel = panzoomInstance.zoomWithWheel;

//     // стартовый scale — используем frameScale, чтобы картинка полностью поместилась,
//     // а если картинка меньшего размера — она будет увеличена до окна (frameScale > 1)

//     let startScale = frameScale;

//     if (frameScale > 1) {
//         // картинка была маленькой → мы ее растянули до окна
//         // теперь Panzoom должен считать это минимальным zoom (1)
//         panzoomInstance.setOptions({ minScale: 1 });
//         startScale = 1;
//     } else {
//         // картинка больше окна → оставляем minScale меньше 1
//         panzoomInstance.setOptions({ minScale: 0.2 });
//     }


//     panzoomInstance.zoom(startScale, { animate: false });

//     // видимый размер после зума
//     const dispW = natW * startScale;
//     const dispH = natH * startScale;

//     // центрируем картинку в рамке (рамка сейчас nat*frameScale, поэтому обычно offset = 0)
//     const offsetX = (modalInner.clientWidth - dispW) / 2;
//     const offsetY = (modalInner.clientHeight - dispH) / 2;

//     panzoomInstance.pan(offsetX, offsetY, { animate: false });

//     // ещё раз применим pan через таймаут — чтобы учесть возможную асинхронность layout
//     setTimeout(() => {
//       panzoomInstance.pan(offsetX, offsetY, { animate: false });
//     }, 20);
//   }

//   function setImageAndInit(src) {
//     destroyPanzoom();
//     modalImg.src = src;

//     if (modalImg.decode) {
//       modalImg.decode().then(() => {
//         requestAnimationFrame(() => createPanzoomUsingNaturalSize());
//       }).catch(() => {
//         modalImg.onload = function () {
//           modalImg.onload = null;
//           requestAnimationFrame(() => createPanzoomUsingNaturalSize());
//         };
//       });
//     } else {
//       modalImg.onload = function () {
//         modalImg.onload = null;
//         requestAnimationFrame(() => createPanzoomUsingNaturalSize());
//       };
//     }
//   }

//   function openModal(index) {
//     currentIndex = index;
//     setImageAndInit(images[currentIndex]);
//     modal.classList.add('is-active');
//     document.body.style.overflow = 'hidden';
//   }

//   function closeModal() {
//     modal.classList.remove('is-active');
//     document.body.style.overflow = '';
//     destroyPanzoom();
//   }

//   function showNext() {
//     if (!images.length) return;
//     currentIndex = (currentIndex + 1) % images.length;
//     setImageAndInit(images[currentIndex]);
//   }

//   function showPrev() {
//     if (!images.length) return;
//     currentIndex = (currentIndex - 1 + images.length) % images.length;
//     setImageAndInit(images[currentIndex]);
//   }

//   thumbs.forEach((img, index) => img.addEventListener('click', () => openModal(index)));
//   btnClose.addEventListener('click', closeModal);
//   backdrop.addEventListener('click', closeModal);
//   btnNext.addEventListener('click', showNext);
//   btnPrev.addEventListener('click', showPrev);

//   document.addEventListener('keydown', (e) => {
//     if (!modal.classList.contains('is-active')) return;
//     if (e.key === 'Escape') closeModal();
//     if (e.key === 'ArrowRight') showNext();
//     if (e.key === 'ArrowLeft') showPrev();
//   });

//   // swipe
//   let touchStartX = 0, touchStartY = 0, touchEndX = 0, touchEndY = 0, isSwiping = false;
//   const SWIPE_THRESHOLD = 50, VERTICAL_LIMIT = 80;
//   function onTouchStart(e){ if(!modal.classList.contains('is-active')) return; const t=e.touches[0]; touchStartX=t.clientX; touchStartY=t.clientY; touchEndX=touchStartX; touchEndY=touchStartY; isSwiping=false; }
//   function onTouchMove(e){ if(!modal.classList.contains('is-active')) return; const t=e.touches[0]; touchEndX=t.clientX; touchEndY=t.clientY; const dx=touchEndX-touchStartX, dy=touchEndY-touchStartY; if(!isSwiping && Math.abs(dx)>10 && Math.abs(dy)<VERTICAL_LIMIT) isSwiping=true; if(isSwiping) e.preventDefault(); }
//   function onTouchEnd(e){ if(!modal.classList.contains('is-active')) return; if(!isSwiping) return; const dx=touchEndX-touchStartX, dy=touchEndY-touchStartY; if(Math.abs(dy)>VERTICAL_LIMIT) return; if(Math.abs(dx)>SWIPE_THRESHOLD) dx<0?showNext():showPrev(); }
//   modal.addEventListener('touchstart', onTouchStart, { passive:false });
//   modal.addEventListener('touchmove', onTouchMove, { passive:false });
//   modal.addEventListener('touchend', onTouchEnd);

//   // resize: пересчитать позицию/масштаб
//   window.addEventListener('resize', () => {
//     if (!modal.classList.contains('is-active')) return;
//     if (!modalImg.src) return;
//     setTimeout(() => {
//       createPanzoomUsingNaturalSize();
//     }, 60);
//   });
// });

document.addEventListener('DOMContentLoaded', function () {
  const thumbs = Array.from(document.querySelectorAll('.js-gallery-thumb'));
  if (!thumbs.length) return;

  const modal = document.getElementById('photoModal');
  const modalInner = modal.querySelector('.photo-modal-inner');
  const modalImg = document.getElementById('photoModalImg');
  const btnClose = modal.querySelector('.photo-modal-close');
  const btnPrev = modal.querySelector('.photo-modal-prev');
  const btnNext = modal.querySelector('.photo-modal-next');
  const backdrop = modal.querySelector('.photo-modal-backdrop');

  const images = thumbs.map(img => img.getAttribute('data-full') || img.src);
  let currentIndex = 0;
  let panzoomInstance = null;

  function destroyPanzoom() {
    if (panzoomInstance) {
      try { panzoomInstance.destroy(); } catch (e) {}
      panzoomInstance = null;
    }
    modalImg.style.transform = '';
    modalImg.style.width = '';
    modalImg.style.height = '';
    modalImg.style.position = '';
    modalInner.style.width = '';
    modalInner.style.height = '';
    // очищаем обработчик колеса
    modalInner.onwheel = null;
  }

  function createPanzoomUsingNaturalSize() {
    destroyPanzoom();

    const natW = modalImg.naturalWidth || modalImg.width;
    const natH = modalImg.naturalHeight || modalImg.height;
    if (!natW || !natH) {
      panzoomInstance = Panzoom(modalImg, { maxScale: 6, minScale: 0.3, contain: 'outside' });
      modalInner.onwheel = panzoomInstance.zoomWithWheel;
      return;
    }

    const maxFrameW = Math.round(window.innerWidth * 0.9);
    const maxFrameH = Math.round(window.innerHeight * 0.9);
    const frameScale = Math.min(maxFrameW / natW, maxFrameH / natH);

    // Если картинка маленькая (вписывается с увеличением), используем консервативный подход:
    const SMALL_THRESHOLD = 0.95; // если frameScale >= 0.95 — считаем картинку "малом"
    if (frameScale >= SMALL_THRESHOLD) {
      // поведение как в варианте A
      const dispW = Math.max(1, Math.round(natW * frameScale));
      const dispH = Math.max(1, Math.round(natH * frameScale));
      modalInner.style.width = dispW + 'px';
      modalInner.style.height = dispH + 'px';

      modalImg.style.position = 'absolute';
      modalImg.style.left = '0px';
      modalImg.style.top = '0px';
      modalImg.style.width = dispW + 'px';
      modalImg.style.height = dispH + 'px';
      modalImg.style.maxWidth = 'none';
      modalImg.style.maxHeight = 'none';
      modalImg.style.objectFit = 'contain';
      modalImg.style.transform = 'none';
      modalImg.style.transformOrigin = '50% 50%';

      panzoomInstance = Panzoom(modalImg, { maxScale: 8, minScale: 1, contain: 'outside' });
      modalInner.onwheel = panzoomInstance.zoomWithWheel;
      try { panzoomInstance.zoom(1, { animate: false }); } catch(e){}
      try { panzoomInstance.pan(0,0, { animate: false }); } catch(e){}
      return;
    }

    // Иначе — поведение "натуральных пикселей" (как у вас было раньше, но с более аккуратной установкой minScale)
    modalInner.style.width = Math.round(natW * frameScale) + 'px';
    modalInner.style.height = Math.round(natH * frameScale) + 'px';

    modalImg.style.position = 'absolute';
    modalImg.style.left = '0px';
    modalImg.style.top = '0px';
    modalImg.style.width = natW + 'px';
    modalImg.style.height = natH + 'px';
    modalImg.style.maxWidth = 'none';
    modalImg.style.maxHeight = 'none';
    modalImg.style.objectFit = 'none';
    modalImg.style.transformOrigin = '0 0';
    modalImg.style.transform = 'none';

    panzoomInstance = Panzoom(modalImg, {
      maxScale: 8,
      minScale: 0.2,
      contain: 'outside'
    });
    modalInner.onwheel = panzoomInstance.zoomWithWheel;

    // стартовый scale — вписанный
    const startScale = frameScale;
    // корректируем minScale: не ниже вписанного
    if (typeof panzoomInstance.setOptions === 'function') {
      panzoomInstance.setOptions({ minScale: Math.max(0.0001, startScale) });
    } else if (panzoomInstance.options) {
      panzoomInstance.options.minScale = Math.max(0.0001, startScale);
    }

    try { panzoomInstance.zoom(startScale, { animate: false }); } catch(e){}
    const dispW2 = natW * startScale, dispH2 = natH * startScale;
    const offsetX = (modalInner.clientWidth - dispW2) / 2;
    const offsetY = (modalInner.clientHeight - dispH2) / 2;
    try { panzoomInstance.pan(offsetX, offsetY, { animate: false }); } catch(e){}
    setTimeout(() => { try { panzoomInstance.pan(offsetX, offsetY, { animate: false }); } catch(e){} }, 20);
  }


  function setImageAndInit(src) {
    destroyPanzoom();
    modalImg.src = src;

    if (modalImg.decode) {
      modalImg.decode().then(() => {
        requestAnimationFrame(() => createPanzoomUsingNaturalSize());
      }).catch(() => {
        modalImg.onload = function () {
          modalImg.onload = null;
          requestAnimationFrame(() => createPanzoomUsingNaturalSize());
        };
      });
    } else {
      modalImg.onload = function () {
        modalImg.onload = null;
        requestAnimationFrame(() => createPanzoomUsingNaturalSize());
      };
    }
  }

  function openModal(index) {
    currentIndex = index;
    setImageAndInit(images[currentIndex]);
    modal.classList.add('is-active');
    document.body.style.overflow = 'hidden';
  }

  function closeModal() {
    modal.classList.remove('is-active');
    document.body.style.overflow = '';
    destroyPanzoom();
  }

  function showNext() {
    if (!images.length) return;
    currentIndex = (currentIndex + 1) % images.length;
    setImageAndInit(images[currentIndex]);
  }

  function showPrev() {
    if (!images.length) return;
    currentIndex = (currentIndex - 1 + images.length) % images.length;
    setImageAndInit(images[currentIndex]);
  }

  thumbs.forEach((img, index) => img.addEventListener('click', () => openModal(index)));
  btnClose.addEventListener('click', closeModal);
  backdrop.addEventListener('click', closeModal);
  btnNext.addEventListener('click', showNext);
  btnPrev.addEventListener('click', showPrev);

  document.addEventListener('keydown', (e) => {
    if (!modal.classList.contains('is-active')) return;
    if (e.key === 'Escape') closeModal();
    if (e.key === 'ArrowRight') showNext();
    if (e.key === 'ArrowLeft') showPrev();
  });

  // swipe
  let touchStartX = 0, touchStartY = 0, touchEndX = 0, touchEndY = 0, isSwiping = false;
  const SWIPE_THRESHOLD = 50, VERTICAL_LIMIT = 80;
  function onTouchStart(e){ if(!modal.classList.contains('is-active')) return; const t=e.touches[0]; touchStartX=t.clientX; touchStartY=t.clientY; touchEndX=touchStartX; touchEndY=touchStartY; isSwiping=false; }
  function onTouchMove(e){ if(!modal.classList.contains('is-active')) return; const t=e.touches[0]; touchEndX=t.clientX; touchEndY=t.clientY; const dx=touchEndX-touchStartX, dy=touchEndY-touchStartY; if(!isSwiping && Math.abs(dx)>10 && Math.abs(dy)<VERTICAL_LIMIT) isSwiping=true; if(isSwiping) e.preventDefault(); }
  function onTouchEnd(e){ if(!modal.classList.contains('is-active')) return; if(!isSwiping) return; const dx=touchEndX-touchStartX, dy=touchEndY-touchStartY; if(Math.abs(dy)>VERTICAL_LIMIT) return; if(Math.abs(dx)>SWIPE_THRESHOLD) dx<0?showNext():showPrev(); }
  modal.addEventListener('touchstart', onTouchStart, { passive:false });
  modal.addEventListener('touchmove', onTouchMove, { passive:false });
  modal.addEventListener('touchend', onTouchEnd);

  window.addEventListener('resize', () => {
    if (!modal.classList.contains('is-active')) return;
    if (!modalImg.src) return;
    setTimeout(() => {
      createPanzoomUsingNaturalSize();
    }, 60);
  });
});

