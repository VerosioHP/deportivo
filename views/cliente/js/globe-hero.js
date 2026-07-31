import * as THREE from 'three';
import { CSS2DRenderer, CSS2DObject } from 'three/addons/renderers/CSS2DRenderer.js';

const root = document.querySelector('[data-globe-root]');
const canvas = document.querySelector('[data-globe-canvas]');
if (!root || !canvas) {
    // Contenedor del globo no presente en esta página.
} else {
    initGlobe(root, canvas);
}

function initGlobe(root, canvas) {
const EARTH_URL = 'https://cdn.jsdelivr.net/npm/three-globe@2.31.0/example/img/earth-blue-marble.jpg';
const EARTH_FALLBACK = 'https://cdn.jsdelivr.net/npm/three-globe@2.31.0/example/img/earth-day.jpg';

/** Centroides aproximados (lat, lon) — nombres en español */
const COUNTRIES = [
    { name: 'Colombia', lat: 4.6, lon: -74.1 },
    { name: 'México', lat: 23.6, lon: -102.5 },
    { name: 'Estados Unidos', lat: 39.8, lon: -98.5 },
    { name: 'Canadá', lat: 56.1, lon: -106.3 },
    { name: 'Brasil', lat: -10.8, lon: -52.9 },
    { name: 'Argentina', lat: -38.4, lon: -63.6 },
    { name: 'Chile', lat: -35.7, lon: -71.5 },
    { name: 'Perú', lat: -9.2, lon: -75.0 },
    { name: 'Ecuador', lat: -1.8, lon: -78.2 },
    { name: 'Venezuela', lat: 6.4, lon: -66.6 },
    { name: 'España', lat: 40.5, lon: -3.7 },
    { name: 'Francia', lat: 46.2, lon: 2.2 },
    { name: 'Alemania', lat: 51.2, lon: 10.4 },
    { name: 'Italia', lat: 41.9, lon: 12.6 },
    { name: 'Reino Unido', lat: 54.0, lon: -2.5 },
    { name: 'Portugal', lat: 39.4, lon: -8.2 },
    { name: 'Rusia', lat: 61.5, lon: 105.3 },
    { name: 'China', lat: 35.9, lon: 104.2 },
    { name: 'Japón', lat: 36.2, lon: 138.3 },
    { name: 'India', lat: 20.6, lon: 79.0 },
    { name: 'Australia', lat: -25.3, lon: 133.8 },
    { name: 'Nueva Zelanda', lat: -40.9, lon: 174.9 },
    { name: 'Sudáfrica', lat: -30.6, lon: 22.9 },
    { name: 'Egipto', lat: 26.8, lon: 30.8 },
    { name: 'Nigeria', lat: 9.1, lon: 8.7 },
    { name: 'Kenia', lat: -0.0, lon: 37.9 },
    { name: 'Marruecos', lat: 31.8, lon: -7.1 },
    { name: 'Turquía', lat: 38.96, lon: 35.2 },
    { name: 'Arabia Saudita', lat: 23.9, lon: 45.1 },
    { name: 'Emiratos Árabes', lat: 23.4, lon: 53.8 },
    { name: 'Indonesia', lat: -2.5, lon: 118.0 },
    { name: 'Tailandia', lat: 15.9, lon: 100.9 },
    { name: 'Corea del Sur', lat: 35.9, lon: 127.8 },
    { name: 'Filipinas', lat: 12.9, lon: 121.8 },
    { name: 'Vietnam', lat: 14.1, lon: 108.3 },
    { name: 'Pakistán', lat: 30.4, lon: 69.3 },
    { name: 'Irán', lat: 32.4, lon: 53.7 },
    { name: 'Kazajistán', lat: 48.0, lon: 67.0 },
    { name: 'Ucrania', lat: 48.4, lon: 31.2 },
    { name: 'Polonia', lat: 51.9, lon: 19.1 },
    { name: 'Suecia', lat: 60.1, lon: 18.6 },
    { name: 'Noruega', lat: 60.5, lon: 8.5 },
    { name: 'Grecia', lat: 39.1, lon: 21.8 },
    { name: 'Cuba', lat: 21.5, lon: -77.8 },
    { name: 'Rep. Dominicana', lat: 18.7, lon: -70.2 },
    { name: 'Panamá', lat: 8.5, lon: -80.8 },
    { name: 'Costa Rica', lat: 9.7, lon: -83.8 },
    { name: 'Bolivia', lat: -16.3, lon: -63.6 },
    { name: 'Paraguay', lat: -23.4, lon: -58.4 },
    { name: 'Uruguay', lat: -32.5, lon: -55.8 },
    { name: 'Islandia', lat: 64.96, lon: -19.0 },
    { name: 'Groenlandia', lat: 71.7, lon: -42.6 },
    { name: 'Madagascar', lat: -18.8, lon: 46.9 },
    { name: 'Etiopía', lat: 9.1, lon: 40.5 },
    { name: 'Argelia', lat: 28.0, lon: 1.7 },
];

function latLonToVector3(lat, lon, radius) {
    const phi = (90 - lat) * (Math.PI / 180);
    const theta = (lon + 180) * (Math.PI / 180);
    return new THREE.Vector3(
        -radius * Math.sin(phi) * Math.cos(theta),
        radius * Math.cos(phi),
        radius * Math.sin(phi) * Math.sin(theta)
    );
}

const scene = new THREE.Scene();
const camera = new THREE.PerspectiveCamera(45, 1, 0.1, 100);
camera.position.z = 2.55;

const renderer = new THREE.WebGLRenderer({
    canvas,
    antialias: true,
    alpha: true,
    powerPreference: 'high-performance',
});
renderer.setPixelRatio(Math.min(window.devicePixelRatio || 1, 2));
renderer.setClearColor(0x000000, 0);

const labelRenderer = new CSS2DRenderer();
labelRenderer.domElement.className = 'hero-globe-labels';
root.appendChild(labelRenderer.domElement);

const ambient = new THREE.AmbientLight(0xffffff, 0.55);
const key = new THREE.DirectionalLight(0xffffff, 1.15);
key.position.set(4, 2, 3);
const fill = new THREE.DirectionalLight(0x88aaff, 0.35);
fill.position.set(-3, -1, -2);
scene.add(ambient, key, fill);

const earthGroup = new THREE.Group();
scene.add(earthGroup);

const material = new THREE.MeshStandardMaterial({
    color: 0x1a3a5c,
    roughness: 0.85,
    metalness: 0.05,
});
const earth = new THREE.Mesh(new THREE.SphereGeometry(1, 64, 64), material);
earthGroup.add(earth);

earthGroup.add(new THREE.Mesh(
    new THREE.SphereGeometry(1.035, 48, 48),
    new THREE.MeshBasicMaterial({
        color: 0x4da3ff,
        transparent: true,
        opacity: 0.12,
        side: THREE.BackSide,
    })
));

const labels = [];
COUNTRIES.forEach((country) => {
    const el = document.createElement('div');
    el.className = 'hero-globe-country';
    el.textContent = country.name;

    const obj = new CSS2DObject(el);
    obj.position.copy(latLonToVector3(country.lat, country.lon, 1.02));
    earthGroup.add(obj);
    labels.push({ obj, el });
});

const loader = new THREE.TextureLoader();
loader.setCrossOrigin('anonymous');
loader.load(
    EARTH_URL,
    (texture) => {
        texture.colorSpace = THREE.SRGBColorSpace;
        material.map = texture;
        material.color.set(0xffffff);
        material.needsUpdate = true;
    },
    undefined,
    () => {
        loader.load(EARTH_FALLBACK, (texture) => {
            texture.colorSpace = THREE.SRGBColorSpace;
            material.map = texture;
            material.color.set(0xffffff);
            material.needsUpdate = true;
        });
    }
);

let rotY = 0.35;
let rotX = 0.18;
let velY = 0;
let velX = 0;
const autoSpin = 0.0016;
const MAX_X = 1.15;
let dragging = false;
let lastX = 0;
let lastY = 0;
let lastInteract = 0;

function clampX(v) {
    return Math.max(-MAX_X, Math.min(MAX_X, v));
}

function resize() {
    const rect = root.getBoundingClientRect();
    const size = Math.max(220, Math.min(rect.width, rect.height || rect.width));
    const w = Math.floor(size);
    const h = Math.floor(size);
    renderer.setSize(w, h, false);
    labelRenderer.setSize(w, h);
    camera.aspect = w / h;
    camera.updateProjectionMatrix();
}

function pointerPos(e) {
    if (e.touches?.[0]) {
        return { x: e.touches[0].clientX, y: e.touches[0].clientY };
    }
    return { x: e.clientX, y: e.clientY };
}

function onPointerDown(e) {
    dragging = true;
    const p = pointerPos(e);
    lastX = p.x;
    lastY = p.y;
    lastInteract = performance.now();
    root.classList.add('is-dragging');
}

function onPointerMove(e) {
    if (!dragging) return;
    const p = pointerPos(e);
    const dx = p.x - lastX;
    const dy = p.y - lastY;
    lastX = p.x;
    lastY = p.y;
    velY = dx * 0.005;
    velX = dy * 0.005;
    rotY += velY;
    rotX = clampX(rotX + velX);
    lastInteract = performance.now();
    if (e.cancelable && e.pointerType !== 'touch') e.preventDefault();
}

function onPointerUp() {
    dragging = false;
    root.classList.remove('is-dragging');
}

root.addEventListener('pointerdown', onPointerDown);
window.addEventListener('pointermove', onPointerMove, { passive: false });
window.addEventListener('pointerup', onPointerUp);
window.addEventListener('pointercancel', onPointerUp);

root.addEventListener('touchstart', (e) => {
    if (!e.touches[0]) return;
    dragging = true;
    lastX = e.touches[0].clientX;
    lastY = e.touches[0].clientY;
    lastInteract = performance.now();
    root.classList.add('is-dragging');
}, { passive: true });

root.addEventListener('touchmove', (e) => {
    if (!dragging || !e.touches[0]) return;
    const x = e.touches[0].clientX;
    const y = e.touches[0].clientY;
    const dx = x - lastX;
    const dy = y - lastY;
    lastX = x;
    lastY = y;
    velY = dx * 0.005;
    velX = dy * 0.005;
    rotY += velY;
    rotX = clampX(rotX + velX);
    lastInteract = performance.now();
}, { passive: true });

root.addEventListener('touchend', onPointerUp);

window.addEventListener('resize', resize);
resize();

const worldPos = new THREE.Vector3();
const camDir = new THREE.Vector3();

function updateLabelsVisibility() {
    camDir.copy(camera.position).normalize();
    labels.forEach(({ obj, el }) => {
        obj.getWorldPosition(worldPos);
        const facing = worldPos.clone().normalize().dot(camDir);
        const visible = facing > 0.18;
        el.classList.toggle('is-hidden', !visible);
        el.style.opacity = visible ? String(Math.min(1, (facing - 0.18) / 0.35 + 0.35)) : '0';
    });
}

function animate(now) {
    requestAnimationFrame(animate);

    const idle = now - lastInteract > 1800;
    if (idle && !dragging) {
        rotY += autoSpin;
    }

    earthGroup.rotation.y += (rotY - earthGroup.rotation.y) * 0.1;
    earthGroup.rotation.x += (rotX - earthGroup.rotation.x) * 0.1;
    earthGroup.rotation.y += velY;
    earthGroup.rotation.x = clampX(earthGroup.rotation.x + velX);
    rotY += velY;
    rotX = clampX(rotX + velX);
    velY *= 0.92;
    velX *= 0.92;

    updateLabelsVisibility();
    renderer.render(scene, camera);
    labelRenderer.render(scene, camera);
}

requestAnimationFrame(animate);
}
