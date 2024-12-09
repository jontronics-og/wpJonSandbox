document.addEventListener('DOMContentLoaded', () => {
    // Dot background effect
    const dotBackground = document.createElement('div');
    dotBackground.className = 'dot-background';
    
    const dots = [];
    for (let i = 0; i < 200; i++) {
        const dot = document.createElement('div');
        dot.className = 'dot';
        dotBackground.appendChild(dot);
        dots.push(dot);
    }
    
    document.querySelector('.testimonials-section').appendChild(dotBackground);

    function randomFade() {
        const numDots = Math.floor(Math.random() * 5) + 1;
        
        for (let i = 0; i < numDots; i++) {
            const randomIndex = Math.floor(Math.random() * dots.length);
            const dot = dots[randomIndex];
            dot.classList.add('fade');
            
            const duration = Math.random() * 2000 + 1000;
            setTimeout(() => {
                dot.classList.remove('fade');
            }, duration);
        }
        
        const nextFade = Math.random() * 1000 + 500;
        setTimeout(randomFade, nextFade);
    }

    randomFade();

    // Testimonials data
    const testimonials = [
        {
            quote: "Antimetal optimizes our cloud spend without compromising on security. Their expertise in striking the perfect balance between cost optimization and robust security measures makes them an invaluable asset.",
            author: "Nicolas Chaillan",
            role: "Former U.S. Air Force and Space Force<br>Chief Software Officer (CSO)"
        },
        {
            quote: "Their deep understanding of cloud infrastructure and security protocols has transformed how we approach our cloud architecture. The cost savings have been substantial without any compromise on performance.",
            author: "Sarah Chen",
            role: "Chief Technology Officer<br>Fortune 500 Financial Services"
        },
        {
            quote: "We've seen a 40% reduction in cloud costs while enhancing our security posture. Their collaborative approach ensures our team understands and can maintain the optimizations implemented.",
            author: "Michael Anderson",
            role: "VP of Engineering<br>Leading SaaS Platform"
        }
    ];

    let currentIndex = 0;
    const quoteElement = document.querySelector('.testimonial-text blockquote');
    const authorNameElement = document.querySelector('.author-details h3.details');
    const authorRoleElement = document.querySelector('.author-details p');
    
    function updateTestimonial() {
        // Start fade out animation
        quoteElement.style.opacity = '0';
        authorNameElement.style.opacity = '0';
        authorRoleElement.style.opacity = '0';
        
        // After fade out, update content and fade in
        setTimeout(() => {
            const testimonial = testimonials[currentIndex];
            
            // Update content
            quoteElement.innerHTML = `"${testimonial.quote}"`;
            authorNameElement.textContent = testimonial.author;
            authorRoleElement.innerHTML = testimonial.role;
            
            // Start fade in animation
            quoteElement.style.opacity = '1';
            authorNameElement.style.opacity = '1';
            authorRoleElement.style.opacity = '1';
            
            // Update index for next rotation
            currentIndex = (currentIndex + 1) % testimonials.length;
        }, 1000);
    }
    
    // Set initial testimonial
    const initialTestimonial = testimonials[0];
    quoteElement.innerHTML = `"${initialTestimonial.quote}"`;
    authorNameElement.textContent = initialTestimonial.author;
    authorRoleElement.innerHTML = initialTestimonial.role;
    
    // Rotate testimonials every 5 seconds
    setInterval(updateTestimonial, 5000);
});