// Initialize GSAP
gsap.registerPlugin(MotionPathPlugin);

// Create background dots
const dotGrid = document.querySelector('.dot-grid');
for (let i = 0; i < 400; i++) {
    const dot = document.createElement('div');
    dot.className = 'bg-dot';
    dotGrid.appendChild(dot);
}

// Center dots animation
gsap.to(".center-dot", {
    scale: 1.2,
    opacity: 0.5,
    duration: 0.8,
    ease: "power1.inOut",
    stagger: {
        each: 0.1,
        repeat: -1,
        yoyo: true
    }
});

// Set initial opacity for all support icons
gsap.set(".support-icon img", {
    opacity: 0
});

// AWS Services animations
const serviceOrder = ['rds', 'ec2', 's3', 'lambda', 'cloudwatch'];
const tl = gsap.timeline({delay: 0.5});

// First sequence: Fade in and scale up
serviceOrder.forEach(id => {
    tl.to(`#${id}`, {
        opacity: 1,
        scale: 1,
        duration: 0.6,
        ease: "back.out(1.7)"
    });
});

// Second sequence: Draw circles, show checkmarks, and fade in icons
serviceOrder.forEach(id => {
    tl.to(`#${id} circle`, {
        strokeDashoffset: 0,
        duration: 0.8,
        ease: "none"
    })
    .to(`#${id} .check-mark`, {
        scale: 1,
        opacity: 1,
        duration: 0.4,
        ease: "back.out(2)"
    }, "<0.4")
    .to(`#${id} .service-label`, {
        opacity: 1,
        duration: 0.4
    }, "<")
    .to(`#${id} .support-icon img`, {
        opacity: 1,
        duration: 0.4,
        ease: "power2.out"
    }, ">-0.2");
});

// Wave Text Animation
function createWave() {
    const waveTl = gsap.timeline();
    
    waveTl.to(".wave-letter-hero", {
        y: -15,
        duration: 0.5,
        ease: "power1.inOut",
        stagger: {
            each: 0.1,
            yoyo: true,
            repeat: 1
        }
    });

    return waveTl;
}

// Create a master timeline for the wave animation
const masterTl = gsap.timeline({repeat: -1});
masterTl
    .add(createWave())
    .to({}, {duration: 5});