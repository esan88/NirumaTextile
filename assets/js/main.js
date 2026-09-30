/**
* Template Name: BizLand
* Updated: Mar 10 2023 with Bootstrap v5.2.3
* Template URL: https://bootstrapmade.com/bizland-bootstrap-business-template/
* Author: BootstrapMade.com
* License: https://bootstrapmade.com/license/
*/
(function() {
  "use strict";

  /**
   * Easy selector helper function
   */
  const select = (el, all = false) => {
    // Accept a real node (or NodeList) as well as a selector string, so
    // callers can safely pass `document` or an element to `on()`.
    if (typeof el !== 'string') {
      if (all) return el ? [...el] : []
      return el || null
    }
    el = el.trim()
    if (all) {
      return [...document.querySelectorAll(el)]
    } else {
      return document.querySelector(el)
    }
  }

  /**
   * Easy event listener function
   */
  const on = (type, el, listener, all = false) => {
    let selectEl = select(el, all)
    if (selectEl) {
      if (all) {
        selectEl.forEach(e => e.addEventListener(type, listener))
      } else {
        selectEl.addEventListener(type, listener)
      }
    }
  }

  /**
   * Easy on scroll event listener 
   */
  const onscroll = (el, listener) => {
    el.addEventListener('scroll', listener)
  }

  /**
   * Navbar links active state on scroll
   */
  let navbarlinks = select('#navbar .scrollto', true)
  const navbarlinksActive = () => {
    let position = window.scrollY + 200
    navbarlinks.forEach(navbarlink => {
      if (!navbarlink.hash) return
      let section = select(navbarlink.hash)
      if (!section) return
      if (position >= section.offsetTop && position <= (section.offsetTop + section.offsetHeight)) {
        navbarlink.classList.add('active')
      } else {
        navbarlink.classList.remove('active')
      }
    })
  }
  window.addEventListener('load', navbarlinksActive)
  onscroll(document, navbarlinksActive)

  /**
   * Scrolls to an element with header offset
   */
  const scrollto = (el) => {
    let header = select('#header')
    let offset = header.offsetHeight

    if (!header.classList.contains('header-scrolled')) {
      offset -= 16
    }

    let elementPos = select(el).offsetTop
    window.scrollTo({
      top: elementPos - offset,
      behavior: 'smooth'
    })
  }

  /**
   * Header fixed top on scroll
   */
  let selectHeader = select('#header')
  if (selectHeader) {
    let headerOffset = selectHeader.offsetTop
    let nextElement = selectHeader.nextElementSibling
    const headerFixed = () => {
      if ((headerOffset - window.scrollY) <= 0) {
        selectHeader.classList.add('fixed-top')
        nextElement.classList.add('scrolled-offset')
      } else {
        selectHeader.classList.remove('fixed-top')
        nextElement.classList.remove('scrolled-offset')
      }
    }
    window.addEventListener('load', headerFixed)
    onscroll(document, headerFixed)
  }

  /**
   * Back to top button
   */
  let backtotop = select('.back-to-top')
  if (backtotop) {
    const toggleBacktotop = () => {
      if (window.scrollY > 100) {
        backtotop.classList.add('active')
      } else {
        backtotop.classList.remove('active')
      }
    }
    window.addEventListener('load', toggleBacktotop)
    onscroll(document, toggleBacktotop)
  }

  /**
   * Mobile nav toggle
   */
  const setNav = (open) => {
    const bar = select('#navbar')
    if (!bar) return
    bar.classList.toggle('navbar-mobile', open)
    const btn = select('.mobile-nav-toggle')
    if (btn) {
      btn.classList.toggle('is-open', open)
      btn.setAttribute('aria-expanded', open ? 'true' : 'false')
      const icon = btn.querySelector('i')
      if (icon) {
        icon.classList.toggle('bi-list', !open)
        icon.classList.toggle('bi-x', open)
      }
    }
    // close any open dropdown when the sheet closes
    if (!open) {
      select('#navbar .dropdown-active', true).forEach(d => d.classList.remove('dropdown-active'))
    }
  }

  on('click', '.mobile-nav-toggle', function(e) {
    e.preventDefault()
    const navbar = select('#navbar')
    if (!navbar) return
    setNav(!navbar.classList.contains('navbar-mobile'))
  })

  // Escape closes the mobile sheet
  on('keydown', document, function(e) {
    if (e.key !== 'Escape') return
    const navbar = select('#navbar')
    if (!navbar || !navbar.classList.contains('navbar-mobile')) return
    setNav(false)
    const toggle = select('.mobile-nav-toggle')
    if (toggle) toggle.focus()
  })

  /**
   * Mobile nav dropdowns activate
   */
  on('click', '.navbar .dropdown > a', function(e) {
    const navbar = select('#navbar')
    if (navbar && navbar.classList.contains('navbar-mobile')) {
      e.preventDefault()
      if (this.nextElementSibling) this.nextElementSibling.classList.toggle('dropdown-active')
    }
  }, true)

  /**
   * Scrool with ofset on links with a class name .scrollto
   */
  on('click', '.scrollto', function(e) {
    if (select(this.hash)) {
      e.preventDefault()

      const navbar = select('#navbar')
      if (navbar && navbar.classList.contains('navbar-mobile')) {
        setNav(false)
      }
      scrollto(this.hash)
    }
  }, true)

  /**
   * Scroll with ofset on page load with hash links in the url
   */
  window.addEventListener('load', () => {
    if (window.location.hash) {
      if (select(window.location.hash)) {
        scrollto(window.location.hash)
      }
    }
  });

  /**
   * Preloader
   */
  let preloader = select('#preloader');
  if (preloader) {
    window.addEventListener('load', () => {
      preloader.remove()
    });
  }

  /**
   * Safe plugin bootstrap.
   *
   * Every vendor initialisation used to run unguarded inside this IIFE, so a
   * single failed or blocked script (GLightbox, Swiper, Isotope, PureCounter)
   * threw a ReferenceError and aborted everything after it - including
   * AOS.init(). Because AOS CSS sets opacity:0 on [data-aos^=fade] and
   * [data-aos^=zoom], a dead AOS.init() left whole sections invisible.
   * Each init is now independent and fails soft.
   */
  const safe = (name, fn) => {
    try { fn() } catch (err) {
      console.warn('[main] ' + name + ' init skipped:', err && err.message)
    }
  }

  /**
   * Initiate glightbox
   */
  safe('GLightbox', () => {
    if (typeof GLightbox === 'function') GLightbox({ selector: '.glightbox' })
  })

  /**
   * Skills animation
   */
  let skilsContent = select('.skills-content');
  if (skilsContent && typeof Waypoint === 'function') {
    new Waypoint({
      element: skilsContent,
      offset: '80%',
      handler: function(direction) {
        let progress = select('.progress .progress-bar', true);
        progress.forEach((el) => {
          el.style.width = el.getAttribute('aria-valuenow') + '%'
        });
      }
    })
  }

  /**
   * Testimonials slider
   */
  safe('testimonials Swiper', () => {
    if (typeof Swiper === 'function' && select('.testimonials-slider')) {
      new Swiper('.testimonials-slider', {
        speed: 600,
        loop: true,
        autoplay: {
          delay: 5000,
          disableOnInteraction: false
        },
        slidesPerView: 'auto',
        pagination: {
          el: '.testimonials-slider .swiper-pagination',
          type: 'bullets',
          clickable: true
        }
      });
    }
  })

  /**
   * Portfolio isotope and filter
   */
  window.addEventListener('load', () => {
    safe('Isotope', () => {
      if (typeof Isotope !== 'function') return
      let portfolioContainer = select('.portfolio-container');
      if (!portfolioContainer) return

      const portfolioIsotope = new Isotope(portfolioContainer, {
        itemSelector: '.portfolio-item'
      });

      let portfolioFilters = select('#portfolio-flters li', true);
      if (!portfolioFilters.length) return

      on('click', '#portfolio-flters li', function(e) {
        e.preventDefault();
        portfolioFilters.forEach(function(el) {
          el.classList.remove('filter-active');
        });
        this.classList.add('filter-active');

        portfolioIsotope.arrange({
          filter: this.getAttribute('data-filter')
        });
        portfolioIsotope.on('arrangeComplete', function() {
          if (typeof AOS !== 'undefined') AOS.refresh()
        });
      }, true);
    })
  });

  /**
   * Initiate portfolio lightbox
   */
  safe('portfolio GLightbox', () => {
    if (typeof GLightbox === 'function') GLightbox({ selector: '.portfolio-lightbox' })
  })

  /**
   * Portfolio details slider
   */
  safe('details Swiper', () => {
    if (typeof Swiper !== 'function') return
    document.querySelectorAll('.portfolio-details-slider').forEach((el) => {
      new Swiper(el, {
        speed: 400,
        loop: el.querySelectorAll('.swiper-slide').length > 2,
        autoplay: {
          delay: 5000,
          disableOnInteraction: false
        },
        pagination: {
          el: el.querySelector('.swiper-pagination'),
          type: 'bullets',
          clickable: true
        },
        a11y: { enabled: true }
      });
    })
  })

  /**
   * Animation on scroll.
   *
   * Runs first among the load handlers that matter, is wrapped in safe(), and
   * refreshes once late-loading images have settled so AOS positions stay
   * correct.
   */
  const initAos = () => {
    if (typeof AOS === 'undefined') return
    AOS.init({
      duration: 800,
      easing: 'ease-in-out',
      once: true,
      mirror: false,
      offset: 60,
      disable: function () {
        return window.matchMedia('(prefers-reduced-motion: reduce)').matches
      }
    })
    // AOS measures element positions once, so late images shift them. The
    // load event may already have fired by the time we get here, so refresh
    // immediately and again on readyState 'complete'.
    AOS.refresh()
    if (document.readyState !== 'complete') {
      window.addEventListener('load', () => AOS.refresh())
    }
    document.querySelectorAll('img').forEach((img) => {
      if (!img.complete) img.addEventListener('load', () => AOS.refresh(), { once: true })
    })

    /* Safety net. AOS parks un-animated elements at opacity:0 and only
     * reveals them on scroll. If it mis-measures - a late font swap, a
     * fragment jump, an anchor deep-link, a browser quirk - text that is
     * already on screen stays invisible, which is exactly the "blank
     * square" symptom this site had. So reveal anything already inside the
     * viewport that AOS has not animated. Elements below the fold are left
     * alone and still animate normally on scroll. */
    const revealVisible = () => {
      const vh = window.innerHeight || document.documentElement.clientHeight
      document.querySelectorAll('[data-aos]:not(.aos-animate)').forEach((el) => {
        if (el.closest('#preloader')) return
        const r = el.getBoundingClientRect()
        if (r.top < vh && r.bottom > 0) el.classList.add('aos-animate')
      })
    }
    revealVisible()
    window.addEventListener('load', revealVisible)
    window.addEventListener('resize', revealVisible)
    setTimeout(revealVisible, 1500)
    setTimeout(revealVisible, 4000)
  }
  if (document.readyState === 'complete') initAos()
  else window.addEventListener('load', initAos)

  /**
   * Initiate Pure Counter
   */
  safe('PureCounter', () => {
    if (typeof PureCounter === 'function') new PureCounter()
  })

})()