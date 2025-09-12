// Process Section Interactive Features
document.addEventListener('DOMContentLoaded', function() {
    // Intersection Observer for animation triggers
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
                
                // Add staggered animation to step features
                const features = entry.target.querySelectorAll('.step-features li');
                features.forEach((feature, index) => {
                    setTimeout(() => {
                        feature.style.opacity = '1';
                        feature.style.transform = 'translateX(0)';
                    }, index * 100);
                });
            }
        });
    }, observerOptions);

    // Observe all process steps
    const processSteps = document.querySelectorAll('.process-step');
    processSteps.forEach(step => {
        observer.observe(step);
        
        // Initialize step features animation
        const features = step.querySelectorAll('.step-features li');
        features.forEach(feature => {
            feature.style.opacity = '0';
            feature.style.transform = 'translateX(-20px)';
            feature.style.transition = 'all 0.3s ease';
        });
    });

    // Add hover effects to summary cards
    const summaryCards = document.querySelectorAll('.summary-card');
    summaryCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Add click interaction to process steps
    processSteps.forEach(step => {
        step.addEventListener('click', function() {
            // Remove active class from all steps
            processSteps.forEach(s => s.classList.remove('active'));
            
            // Add active class to clicked step
            this.classList.add('active');
            
            // Add ripple effect
            const ripple = document.createElement('div');
            ripple.classList.add('ripple-effect');
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });

    // Add scroll-triggered progress indicator
    const timeline = document.querySelector('.process-timeline');
    if (timeline) {
        const timelineObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // Animate timeline progress
                    const progressLine = entry.target.querySelector('::before');
                    if (progressLine) {
                        progressLine.style.animation = 'timeline-progress 2s ease-out forwards';
                    }
                }
            });
        }, { threshold: 0.5 });
        
        timelineObserver.observe(timeline);
    }

    // Add counter animation for summary values
    const summaryValues = document.querySelectorAll('.summary-value');
    const valueObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounter(entry.target);
            }
        });
    }, { threshold: 0.5 });

    summaryValues.forEach(value => {
        valueObserver.observe(value);
    });

    function animateCounter(element) {
        const text = element.textContent;
        const numbers = text.match(/\d+/g);
        
        if (numbers) {
            numbers.forEach(number => {
                const targetNumber = parseInt(number);
                let currentNumber = 0;
                const increment = targetNumber / 50;
                const timer = setInterval(() => {
                    currentNumber += increment;
                    if (currentNumber >= targetNumber) {
                        currentNumber = targetNumber;
                        clearInterval(timer);
                    }
                    element.textContent = text.replace(number, Math.floor(currentNumber));
                }, 30);
            });
        }
    }
});

// Add CSS for ripple effect
const style = document.createElement('style');
style.textContent = `
    .ripple-effect {
        position: absolute;
        border-radius: 50%;
        background: rgba(0, 212, 255, 0.3);
        transform: scale(0);
        animation: ripple 0.6s linear;
        pointer-events: none;
        top: 50%;
        left: 50%;
        width: 100px;
        height: 100px;
        margin-left: -50px;
        margin-top: -50px;
    }
    
    @keyframes ripple {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
    
    .process-step.active .step-content {
        border-color: var(--primary-color);
        box-shadow: 0 20px 40px rgba(0, 212, 255, 0.2);
    }
    
    .process-step.active .step-number {
        transform: scale(1.1);
        box-shadow: 0 12px 30px rgba(0, 212, 255, 0.4);
    }
    
    @keyframes timeline-progress {
        from {
            height: 0;
        }
        to {
            height: 100%;
        }
    }
`;
document.head.appendChild(style);
