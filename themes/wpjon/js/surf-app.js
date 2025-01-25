// Define NY surf spots
const NY_SURF_SPOTS = {
    canet: {
        name: 'Canet-en-Roussillon',
        lat: 42.6589,
        lng: 3.0340
    },
    rockaway: {
        name: 'Rockaway Beach',
        lat: 40.5825,
        lng: -73.8358
    },
    longBeach: {
        name: 'Long Beach',
        lat: 40.5885,
        lng: -73.6579
    },
    lido: {
        name: 'Lido Beach',
        lat: 40.5908,
        lng: -73.6343
    },
    gilgo: {
        name: 'Gilgo Beach',
        lat: 40.6179,
        lng: -73.3846
    },
    southampton: {
        name: 'Southampton',
        lat: 40.8679,
        lng: -72.3893
    }
};

document.addEventListener('DOMContentLoaded', async function() {
    const checkButton = document.querySelector('#checkSurfBtn');
    const timeButton = document.querySelector('#lastCheckedBtn');
    
    // Check if we've already made API calls today
    const lastCallDate = localStorage.getItem('lastApiCallDate');
    const lastCallTime = localStorage.getItem('lastCallTime');
    const today = new Date().toDateString();
    
    if (lastCallDate === today) {
        checkButton.textContent = 'API Call Limit Reached';
        checkButton.disabled = true;
        timeButton.textContent = `Last checked: ${lastCallTime}`;
        await checkSurfConditions();
    }

    checkButton.addEventListener('click', async function() {
        try {
            checkButton.textContent = 'Checking...';
            checkButton.disabled = true;
            
            await checkSurfConditions();
            
            // Store that we made API calls today
            localStorage.setItem('lastApiCallDate', today);
            
            // Store and format current time
            const now = new Date();
            const timeString = now.toLocaleTimeString();
            localStorage.setItem('lastCallTime', timeString);
            
            // Update buttons
            checkButton.textContent = 'API Call Limit Reached';
            timeButton.textContent = `Last checked: ${timeString}`;
            
        } catch (error) {
            console.error('Error:', error);
            checkButton.textContent = 'Check Surf Conditions';
            checkButton.disabled = false;
        }
    });
});

async function checkSurfConditions() {
    const resultsDiv = document.querySelector('#surfResults');
    const checkButton = document.querySelector('#checkSurfBtn');
    
    try {
        if (!checkButton.disabled) {
            checkButton.textContent = 'Checking...';
            checkButton.disabled = true;
        }
        
        // Debug logging
        console.log('API Root URL:', surfAppData.root_url);
        console.log('Nonce:', surfAppData.nonce ? 'Present' : 'Missing');
        
        // Fetch data for all beaches in parallel
        const beachPromises = Object.entries(NY_SURF_SPOTS).map(([key, beach]) => {
            const apiUrl = `${surfAppData.root_url}surf-app/v1/conditions?lat=${beach.lat}&lng=${beach.lng}`;
            console.log(`Fetching data for ${beach.name}:`, apiUrl);
            
            return fetch(apiUrl, {
                headers: {
                    'X-WP-Nonce': surfAppData.nonce
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => ({
                beachKey: key,
                beachName: beach.name,
                conditions: data
            }))
            .catch(error => {
                console.error(`Error fetching ${beach.name}:`, error);
                throw error;
            });
        });

        const results = await Promise.all(beachPromises);
        displayResults(results);

    } catch (error) {
        console.error('Detailed error:', error);
        resultsDiv.innerHTML = `<div class="error">Error: ${error.message}</div>`;
        
        if (checkButton.textContent !== 'API Call Limit Reached') {
            checkButton.textContent = 'Check Surf Conditions';
            checkButton.disabled = false;
        }
    }
}

function calculateSurfRating(conditions) {
    let score = 0;
    const waveHeight = conditions.waveHeight.noaa;
    const windSpeed = conditions.windSpeed.noaa;
    const wavePeriod = conditions.wavePeriod.noaa;

    // Wave Height Score (0-3 points) - UPDATED for better small wave differentiation
    if (waveHeight < 0.5) {
        score -= 3;  // Even more negative score for very tiny waves
    } else if (waveHeight >= 0.5 && waveHeight < 1) {
        score -= 1;  // Less penalty for waves between 0.5 and 1 ft
    } else if (waveHeight >= 1.5 && waveHeight <= 3) {
        score += 3;
    } else if (waveHeight >= 1 && waveHeight < 1.5) {
        score += 2;
    } else if (waveHeight > 3 && waveHeight <= 4) {
        score += 1;
    }

    // Wave Period Score (0-3 points)
    if (wavePeriod >= 10) {
        score += 3;
    } else if (wavePeriod >= 8) {
        score += 2;
    } else if (wavePeriod >= 6) {
        score += 1;
    }

    // Wind Speed Score (0-4 points)
    if (windSpeed < 10) {
        score += 4;
    } else if (windSpeed < 15) {
        score += 2;
    } else if (windSpeed < 20) {
        score += 1;
    }

    // Ensure the final score doesn't go below 1
    const finalScore = Math.round((score / 10) * 5);
    return Math.max(1, finalScore);
}

function getWindDirection(degrees) {
    const directions = ['N', 'NE', 'E', 'SE', 'S', 'SW', 'W', 'NW'];
    return directions[Math.round(degrees / 45) % 8];
}

function convertToFahrenheit(celsius) {
    if (celsius == null) return null;
    return (celsius * 9/5) + 32;
}

function getRatingInfo(score) {
    switch(score) {
        case 5:
            return { label: 'Epic', color: '#2ecc71' };   // Green
        case 4:
            return { label: 'Great', color: '#3498db' };  // Blue
        case 3:
            return { label: 'Fair', color: '#f1c40f' };   // Yellow
        case 2:
            return { label: 'Poor', color: '#e67e22' };   // Orange
        case 1:
        default:
            return { label: 'Flat', color: '#e74c3c' };   // Red
    }
}

function getWaveHeightNote(height) {
    if (height < 1) return "Too small";
    if (height >= 1.5 && height <= 3) return "Ideal";
    if (height > 3) return "Large waves";
    return "Fair";
}

function getWavePeriodNote(period) {
    if (period >= 10) return "Excellent";
    if (period >= 8) return "Good";
    if (period >= 6) return "Fair";
    return "Choppy";
}

function getWindNote(speed) {
    if (speed < 10) return "Good conditions";
    if (speed < 15) return "Fair conditions";
    return "Strong winds";
}

function displayResults(beachResults) {
    const resultsDiv = document.querySelector('#surfResults');
    let html = '<div class="cards-grid">';
    
    beachResults.forEach(({ beachName, conditions }) => {
        const currentConditions = conditions.hours[0];
        const rating = calculateSurfRating(currentConditions);
        const ratingInfo = getRatingInfo(rating);
        const waveNote = getWaveHeightNote(currentConditions.waveHeight.noaa);
        const periodNote = getWavePeriodNote(currentConditions.wavePeriod.noaa);
        const windNote = getWindNote(currentConditions.windSpeed.noaa);
        
        html += `
            <div class="card">
                <div class="tag-rating">
                    ${rating}/5 <span class="rating-label" style="color: ${ratingInfo.color}">${ratingInfo.label}</span>
                </div>
                
                <h3 class="card-title">${beachName}</h3>
                
                <div class="card-content">
                    <div class="condition-item">
                        <span class="condition-label">Wave Height</span>
                        <span class="condition-value">${currentConditions.waveHeight.noaa?.toFixed(1) || 'N/A'}/ft</span>
                        <span class="condition-note">${waveNote}</span>
                    </div>
                    
                    <div class="condition-item">
                        <span class="condition-label">Wave Period</span>
                        <span class="condition-value">${currentConditions.wavePeriod.noaa?.toFixed(1) || 'N/A'}/s</span>
                        <span class="condition-note">${periodNote}</span>
                    </div>
                    
                    <div class="condition-item">
                        <span class="condition-label">Wind</span>
                        <span class="condition-value">${currentConditions.windSpeed.noaa?.toFixed(1) || 'N/A'}/mph ${getWindDirection(currentConditions.windDirection.noaa)}</span>
                        <span class="condition-note">${windNote}</span>
                    </div>
                    
                    <div class="condition-item">
                        <span class="condition-label">Water Temp</span>
                        <span class="condition-value">${convertToFahrenheit(currentConditions.waterTemperature?.noaa)?.toFixed(1) || 'N/A'}°F</span>
                    </div>
                </div>
            </div>
        `;
    });
    
    html += '</div>';
    resultsDiv.innerHTML = html;
}