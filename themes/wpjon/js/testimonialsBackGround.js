document.addEventListener('DOMContentLoaded', () => {
    // Dot background code remains the same
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
            role: "Former U.S. Air Force and Space Force<br>Chief Software Officer (CSO)",
            avatar: "path-to-avatar.jpg",
            image: "",
            imageAlt: "Military Aircraft"
        },
        {
            quote: "Their deep understanding of cloud infrastructure and security protocols has transformed how we approach our cloud architecture. The cost savings have been substantial without any compromise on performance.",
            author: "Sarah Chen",
            role: "Chief Technology Officer<br>Fortune 500 Financial Services",
            avatar: "path-to-avatar2.jpg",
            image: "",
            imageAlt: "Financial District"
        },
        {
            quote: "We've seen a 40% reduction in cloud costs while enhancing our security posture. Their collaborative approach ensures our team understands and can maintain the optimizations implemented.",
            author: "Michael Anderson",
            role: "VP of Engineering<br>Leading SaaS Platform",
            avatar: "path-to-avatar3.jpg",
            image: "",
            imageAlt: "Tech Office"
        }
    ];

    let currentIndex = 0;
    const quoteElement = document.querySelector('.testimonial-text blockquote');
    const authorInfo = document.querySelector('.author-info');
    const testimonialImage = document.querySelector('.testimonial-image');
    
    function updateTestimonial() {
        // Start fade out animations
        quoteElement.style.animation = 'fadeOutLeft 1s ease forwards';
        authorInfo.style.animation = 'fadeOutLeft 1s ease forwards';
        testimonialImage.style.animation = 'fadeOutLeft 1s ease forwards';
        
        // After fade out, update content and fade in
        setTimeout(() => {
            const testimonial = testimonials[currentIndex];
            
            // Update quote and author info
            quoteElement.innerHTML = testimonial.quote;
            document.querySelector('.author-details h3').textContent = testimonial.author;
            document.querySelector('.author-details p').innerHTML = testimonial.role;
            
            // Update images
            const avatar = document.querySelector('.author-avatar');
            avatar.src = testimonial.avatar;
            avatar.alt = testimonial.author;
            
            testimonialImage.src = testimonial.image;
            testimonialImage.alt = testimonial.imageAlt;
            
            // Start fade in animations
            quoteElement.style.animation = 'fadeInRight 1s ease forwards';
            authorInfo.style.animation = 'fadeInRight 1s ease forwards';
            testimonialImage.style.animation = 'fadeInRight 1s ease forwards';
            
            // Update index for next rotation
            currentIndex = (currentIndex + 1) % testimonials.length;
        }, 1000);
    }
    
    // Set initial testimonial
    const initialTestimonial = testimonials[0];
    quoteElement.innerHTML = initialTestimonial.quote;
    document.querySelector('.author-details h3').textContent = initialTestimonial.author;
    document.querySelector('.author-details p').innerHTML = initialTestimonial.role;
    
    const avatar = document.querySelector('.author-avatar');
    avatar.src = initialTestimonial.avatar;
    avatar.alt = initialTestimonial.author;
    
    testimonialImage.src = initialTestimonial.image;
    testimonialImage.alt = initialTestimonial.imageAlt;
    
    // Rotate testimonials every 5 seconds
    setInterval(updateTestimonial, 5000);
});