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
            quote: "It is my pleasure to recommend to you one of the software developers on my team, Jon Aquarone. I've worked closely with Jon as his direct supervisor and I can tell you he is an outstanding employee. Jon is a very hard-worker who takes great pride in his projects, he also goes out of his way to look for more work, he does not like tickets left undone! He is very smart and a fast learner. Not only is he technically talented, but also a great communicator and teacher who takes the time to help others. In fact, he goes out of his way to explain technical information to co-workers, in clear and concise language that clarifies their understanding.",
            author: "Adriaan Wakefield",
            role: "Director of Development <br> SAPinsider"
        },
        {
            quote: "I had the pleasure of working with Jon Aquarone at Perfect Planner LLC, and I can confidently say that he is an absolute WordPress mastermind. Jon played a crucial role in building our incredible website, bringing both technical expertise and a creative vision that elevated our online presence to new heights. He is fantastic with quality control, ensuring that every aspect of the site is polished to perfection. Jon consistently meets all deadlines and presents work of the highest quality. His turnaround times are incredibly fast, and he always delivers top-notch results. Beyond his technical abilities, Jon genuinely cares about his work and the success of the team, making him an invaluable team player. I recommend Jon with 110% confidence to any organization looking to take their website and online presence to the next level. He's a true professional, and I'm lucky to have had the opportunity to work with him!",
            author: "Ed Danielov",
            role: "Executive Vice President, Marketing <br> Perfect Planner LLC "
        },
        {
            quote: "Jon worked on several of our web projects. He has an extensive technical skillset and a strong work ethic. I'd recommend him for any development work you need help with.",
            author: "Anthony Esper",
            role: "Founder <br> Occupi Inc"
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