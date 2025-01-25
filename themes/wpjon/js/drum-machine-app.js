const audioContext = new (window.AudioContext || window.webkitAudioContext)();
let isPlaying = false;
let currentStep = 0;
let intervalId = null;
const tempo = 120;

const samples = {
   kick: null, 
   snare: null,
   hihat: null
};

let currentInstrument = 'kick';
const patterns = {
   kick: new Array(16).fill(false),
   snare: new Array(16).fill(false),
   hihat: new Array(16).fill(false)
};

async function loadSamples() {
    if (typeof drumSamples === 'undefined') {
        console.log('drumSamples not defined');
        return;
    }
    
    console.log('Available samples:', drumSamples);
    
    for (const [key, url] of Object.entries(drumSamples)) {
        if (!url) continue;
        try {
            const response = await fetch(url);
            const arrayBuffer = await response.arrayBuffer();
            samples[key] = await audioContext.decodeAudioData(arrayBuffer);
            console.log(`${key} sample loaded successfully`);
        } catch (error) {
            console.error(`Error loading ${key} sample:`, error);
        }
    }
}

const kickBtn = document.getElementById('kick-btn');
const snareBtn = document.getElementById('snare-btn');
const hihatBtn = document.getElementById('hihat-btn');

function selectInstrument(instrument) {
   kickBtn.style.background = 'linear-gradient(145deg, #e6e6e6, #d4d4d4)';
   snareBtn.style.background = 'linear-gradient(145deg, #e6e6e6, #d4d4d4)';
   hihatBtn.style.background = 'linear-gradient(145deg, #e6e6e6, #d4d4d4)';
   
   const selectedBtn = document.getElementById(`${instrument}-btn`);
   selectedBtn.style.background = 'linear-gradient(145deg, #a8d8ff, #87ceeb)';
   
   currentInstrument = instrument;
   
   switch(instrument) {
       case 'kick':
           playKick();
           break;
       case 'snare':
           playSnare();
           break;
       case 'hihat':
           playHihat();
           break;
   }
   
   updateGridDisplay();
}

kickBtn.addEventListener('click', () => selectInstrument('kick'));
snareBtn.addEventListener('click', () => selectInstrument('snare'));
hihatBtn.addEventListener('click', () => selectInstrument('hihat'));

const grid = document.getElementById('sequencer-grid');
const cells = [];
for (let i = 0; i < 16; i++) {
   const cell = document.createElement('button');
   cell.className = 'cell';
   cell.dataset.step = i;
   cell.addEventListener('click', () => {
       patterns[currentInstrument][i] = !patterns[currentInstrument][i];
       updateGridDisplay();
   });
   grid.appendChild(cell);
   cells.push(cell);
}

function updateGridDisplay() {
   cells.forEach((cell, index) => {
       cell.classList.toggle('active', patterns[currentInstrument][index]);
   });
}

function playKick() {
   if (samples.kick) {
       const source = audioContext.createBufferSource();
       const gainNode = audioContext.createGain();
       source.buffer = samples.kick;
       source.connect(gainNode);
       gainNode.connect(audioContext.destination);
       gainNode.gain.setValueAtTime(1, audioContext.currentTime);
       source.start();
       return;
   }

   const osc = audioContext.createOscillator();
   const gainNode = audioContext.createGain();
   
   osc.connect(gainNode);
   gainNode.connect(audioContext.destination);

   osc.frequency.setValueAtTime(150, audioContext.currentTime);
   osc.frequency.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.5);
   
   gainNode.gain.setValueAtTime(1, audioContext.currentTime);
   gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.5);

   osc.start(audioContext.currentTime);
   osc.stop(audioContext.currentTime + 0.5);
}

function playSnare() {
   if (samples.snare) {
       const source = audioContext.createBufferSource();
       const gainNode = audioContext.createGain();
       source.buffer = samples.snare;
       source.connect(gainNode);
       gainNode.connect(audioContext.destination);
       gainNode.gain.setValueAtTime(1, audioContext.currentTime);
       source.start();
       return;
   }

   const osc = audioContext.createOscillator();
   const oscGain = audioContext.createGain();
   osc.type = 'triangle';
   osc.frequency.setValueAtTime(180, audioContext.currentTime);
   oscGain.gain.setValueAtTime(0.7, audioContext.currentTime);
   oscGain.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.1);
   osc.connect(oscGain);
   
   const noise = audioContext.createBufferSource();
   const noiseGain = audioContext.createGain();
   const noiseFilter = audioContext.createBiquadFilter();
   
   const bufferSize = audioContext.sampleRate * 0.2;
   const buffer = audioContext.createBuffer(1, bufferSize, audioContext.sampleRate);
   const data = buffer.getChannelData(0);
   for (let i = 0; i < bufferSize; i++) {
       data[i] = Math.random() * 2 - 1;
   }
   
   noise.buffer = buffer;
   noiseFilter.type = 'bandpass';
   noiseFilter.frequency.setValueAtTime(3000, audioContext.currentTime);
   noiseFilter.Q.setValueAtTime(5, audioContext.currentTime);
   
   noiseGain.gain.setValueAtTime(1, audioContext.currentTime);
   noiseGain.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.15);
   
   noise.connect(noiseFilter);
   noiseFilter.connect(noiseGain);
   
   const masterGain = audioContext.createGain();
   masterGain.gain.setValueAtTime(0.8, audioContext.currentTime);
   
   oscGain.connect(masterGain);
   noiseGain.connect(masterGain);
   masterGain.connect(audioContext.destination);
   
   osc.start(audioContext.currentTime);
   noise.start(audioContext.currentTime);
   osc.stop(audioContext.currentTime + 0.2);
   noise.stop(audioContext.currentTime + 0.2);
}

function playHihat() {
   if (samples.hihat) {
       const source = audioContext.createBufferSource();
       const gainNode = audioContext.createGain();
       source.buffer = samples.hihat;
       source.connect(gainNode);
       gainNode.connect(audioContext.destination);
       gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
       source.start();
       return;
   }

   const bufferSize = audioContext.sampleRate * 0.1;
   const buffer = audioContext.createBuffer(1, bufferSize, audioContext.sampleRate);
   const data = buffer.getChannelData(0);
   
   for (let i = 0; i < bufferSize; i++) {
       data[i] = Math.random() * 2 - 1;
   }
   
   const noise = audioContext.createBufferSource();
   noise.buffer = buffer;
   
   const bandpass = audioContext.createBiquadFilter();
   bandpass.type = 'bandpass';
   bandpass.frequency.setValueAtTime(10000, audioContext.currentTime);
   bandpass.Q.setValueAtTime(8, audioContext.currentTime);
   
   const highpass = audioContext.createBiquadFilter();
   highpass.type = 'highpass';
   highpass.frequency.setValueAtTime(7000, audioContext.currentTime);
   
   const gainNode = audioContext.createGain();
   gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
   gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.05);
   
   noise.connect(bandpass);
   bandpass.connect(highpass);
   highpass.connect(gainNode);
   gainNode.connect(audioContext.destination);
   
   noise.start(audioContext.currentTime);
   noise.stop(audioContext.currentTime + 0.05);
}

function step() {
   cells.forEach(cell => cell.classList.remove('playing'));
   cells[currentStep].classList.add('playing');

   if (patterns.kick[currentStep]) playKick();
   if (patterns.snare[currentStep]) playSnare();
   if (patterns.hihat[currentStep]) playHihat();

   currentStep = (currentStep + 1) % 16;
}

document.getElementById('play-button').addEventListener('click', async () => {
   if (!isPlaying) {
       await loadSamples();
       isPlaying = true;
       audioContext.resume();
       intervalId = setInterval(step, (60 / tempo) * 1000 / 4);
   }
});

document.getElementById('stop-button').addEventListener('click', () => {
   isPlaying = false;
   clearInterval(intervalId);
   currentStep = 0;
   cells.forEach(cell => cell.classList.remove('playing'));
});

document.getElementById('clear-button').addEventListener('click', () => {
   patterns[currentInstrument].fill(false);
   updateGridDisplay();
});

loadSamples();