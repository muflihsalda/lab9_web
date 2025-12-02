// Efek fokus input agar lebih smooth
document.querySelectorAll("input").forEach(input => {
    input.addEventListener("focus", () => {
        input.style.transform = "scale(1.02)";
    });
    input.addEventListener("blur", () => {
        input.style.transform = "scale(1)";
    });
});

// Animasi kecil pada tombol saat diklik
document.querySelectorAll("button").forEach(btn => {
    btn.addEventListener("click", () => {
        btn.style.transform = "scale(0.96)";
        setTimeout(() => btn.style.transform = "scale(1)", 150);
    });
});
