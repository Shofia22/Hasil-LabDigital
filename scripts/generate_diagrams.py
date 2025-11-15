from PIL import Image, ImageDraw, ImageFont
import os

def get_font(size):
    try:
        return ImageFont.truetype("arial.ttf", size)
    except IOError:
        return ImageFont.load_default()

os.makedirs("diagrams", exist_ok=True)
font_title = get_font(24)
font_label = get_font(16)

def create_usecase():
    img = Image.new("RGB", (900, 500), (15, 23, 42))
    draw = ImageDraw.Draw(img)
    draw.text((30, 20), "Use Case Diagram", font=font_title, fill=(255, 255, 255))
    draw.line([(0, 60), (900, 60)], fill=(59, 130, 246), width=3)
    actors = ["Pasien", "Laboratorium", "Dokter", "Admin"]
    for idx, name in enumerate(actors):
        x = 50 + idx * 200
        y = 120
        draw.ellipse([(x, y), (x + 60, y + 60)], outline=(248, 250, 252), width=2)
        draw.text((x + 5, y + 70), name, font=font_label, fill=(248, 250, 252))
    usecases = ["Lihat Hasil", "Input Hasil", "Review", "Kirim Notifikasi"]
    for idx, name in enumerate(usecases):
        cx = 130 + idx * 150
        cy = 250
        draw.ellipse([(cx, cy), (cx + 140, cy + 60)], outline=(16, 185, 129), width=3)
        bbox = draw.textbbox((0, 0), name, font=font_label)
        w = bbox[2] - bbox[0]
        draw.text((cx + 70 - w / 2, cy + 20), name, font=font_label, fill=(255, 255, 255))
    for i in range(4):
        start = (80 + i * 200, 150)
        end = (200 + i * 150, 280)
        draw.line([start, end], fill=(248, 250, 252), width=2)
    img.save("diagrams/usecase.png")

def create_dfd():
    img = Image.new("RGB", (900, 500), (2, 6, 23))
    draw = ImageDraw.Draw(img)
    draw.text((30, 20), "DFD Level 0", font=font_title, fill=(236, 72, 153))
    draw.line([(0, 60), (900, 60)], fill=(236, 72, 153), width=3)
    stores = [("Users", "Auth"), ("Lab", "Results"), ("Notifications", "Queue")]
    for idx, (title, desc) in enumerate(stores):
        x = 80 + idx * 260
        y = 130
        draw.rectangle([(x, y), (x + 200, y + 90)], outline=(34, 197, 94), width=3)
        draw.text((x + 10, y + 10), title, font=font_label, fill=(255, 255, 255))
        draw.text((x + 10, y + 35), desc, font=font_label, fill=(187, 247, 208))
    draw.rectangle([(320, 280), (580, 360)], outline=(14, 165, 233), width=3)
    draw.text((360, 300), "Process Results", font=font_label, fill=(255, 255, 255))
    draw.line([(170, 220), (360, 280)], fill=(199, 210, 254), width=3)
    draw.polygon([(360, 280), (352, 288), (368, 288)], fill=(199, 210, 254))
    draw.line([(500, 360), (680, 420)], fill=(248, 250, 252), width=3)
    draw.polygon([(680, 420), (672, 428), (688, 428)], fill=(248, 250, 252))
    img.save("diagrams/dfd.png")

def create_drd():
    img = Image.new("RGB", (900, 500), (15, 23, 42))
    draw = ImageDraw.Draw(img)
    draw.text((30, 20), "DRD / ERD Overview", font=font_title, fill=(249, 115, 22))
    draw.line([(0, 60), (900, 60)], fill=(249, 115, 22), width=3)
    entities = ["Users", "LabResults", "Notifications"]
    positions = [(80, 120), (340, 120), (600, 120)]
    fields = [
        ["id PK", "name", "email", "role"],
        ["id PK", "patient_id FK", "doctor_id FK", "status"],
        ["id PK", "user_id FK", "title", "sent_at"],
    ]
    for (x, y), entity, attrs in zip(positions, entities, fields):
        draw.rectangle([(x, y), (x + 220, y + 160)], outline=(14, 165, 233), width=3)
        draw.text((x + 10, y + 10), entity, font=font_label, fill=(255, 255, 255))
        for i, attr in enumerate(attrs):
            draw.text((x + 10, y + 40 + 20 * i), attr, font=font_label, fill=(209, 213, 219))
    draw.line([(200, 200), (340, 220)], fill=(250, 204, 21), width=3)
    draw.polygon([(340, 220), (332, 228), (348, 228)], fill=(250, 204, 21))
    draw.line([(460, 200), (600, 220)], fill=(250, 204, 21), width=3)
    draw.polygon([(600, 220), (592, 228), (608, 228)], fill=(250, 204, 21))
    img.save("diagrams/drd.png")

create_usecase()
create_dfd()
create_drd()
