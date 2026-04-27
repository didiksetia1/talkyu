# 💡 Aspirasi Flow System - Talkyu

## Gambaran Alur Aspirasi

Sistem Aspirasi Talkyu dirancang untuk memfasilitasi komunikasi dua arah antara mahasiswa dan BEM (Badan Eksekutif Mahasiswa).

### Proses Lengkap:

```
┌─────────────────────────────────────────────────────────────────────┐
│                    ASPIRASI FLOW SYSTEM                             │
└─────────────────────────────────────────────────────────────────────┘

📝 TAHAP 1: SUBMISSION (Mahasiswa Mengirim Aspirasi)
   └─> Mahasiswa membuat aspirasi baru dengan:
       - Nama (optional)
       - Kritik/Saran/Masukan
       - Rating (1-5)
       └─> Status: SUBMITTED ✅

🌍 TAHAP 2: VISIBLE (Aspirasi Terlihat ke Semua Mahasiswa)
   └─> Aspirasi muncul di timeline untuk semua user
       └─> Mahasiswa bisa:
           ✅ Vote (👍) - Unlimited votes
           ✅ Comment (💬) - Berikan feedback/masukan
           ✅ View (👁️) - Lihat rating & respon BEM

📊 TAHAP 3: POPULAR (BEM Melihat Aspirasi Populer)
   └─> BEM melihat aspirasi berdasarkan:
       ✅ Jumlah votes terbanyak
       ✅ Rating tertinggi
       ✅ Comments terbanyak
       ✅ Yang paling baru
       └─> BEM prioritas aspirasi yang trending

🔍 TAHAP 4: REVIEW & RESPONSE (BEM Meninjau & Memberi Respon)
   └─> BEM membaca aspirasi secara detail
       └─> BEM memberikan response/feedback
       └─> Status: BEING_CONSIDERED 🔄

📢 TAHAP 5: UPDATE STATUS (BEM Memberikan Update)
   └─> BEM update status menjadi:
       ✅ BEING_CONSIDERED (Sedang dipertimbangkan)
       ✅ REALIZED (Sudah direalisasikan)
       └─> Mahasiswa bisa tracking progress

👁️ TAHAP 6: TRACKING (Mahasiswa Melihat Perkembangan)
   └─> Mahasiswa bisa melihat:
       ✅ Status aspirasi mereka
       ✅ Response dari BEM
       ✅ Progress/perkembangan
       └─> Transparansi komunikasi BEM-Mahasiswa ✨
```

---

## Database Schema (Aspirasi Table)

```
aspirasis table:
├─ id
├─ aspirasi_event_id (FK to aspirasi_events)
├─ user_id (FK to users) - Pembuat aspirasi
├─ nama (string|nullable) - Nama pembuat aspirasi
├─ kritik (text)
├─ saran (text)
├─ masukan (text)
├─ rating (integer 1-5)
├─ status (enum: submitted|being_considered|realized) ⭐ NEW
├─ bem_response (text|nullable) - Respon dari BEM ⭐ NEW
├─ votes_count (integer) - Tracking jumlah votes ⭐ NEW
├─ comments_count (integer) - Tracking jumlah comments ⭐ NEW
└─ timestamps (created_at, updated_at)
```

---

## Feature Breakdown

### 1. **Vote System** 👍
- Mahasiswa bisa vote unlimited
- Vote count tracking untuk sorting aspirasi populer
- Unique vote per user (prevent double voting)

### 2. **Comment System** 💬
- Mahasiswa bisa berkomentar pada aspirasi
- Comment count untuk tracking engagement
- Support nested/threaded comments (future enhancement)

### 3. **Status Tracking** 🔄
- **SUBMITTED**: Aspirasi baru, belum ditinjau BEM
- **BEING_CONSIDERED**: BEM sedang mempertimbangkan
- **REALIZED**: BEM sudah melakukan aksi/realisasi

### 4. **BEM Response** 📢
- BEM memberikan feedback/respon
- Bisa berisi:
  - Apa yang akan dilakukan
  - Timeline realisasi
  - Pertimbangan/alasan
  - Terima kasih/apresiasi

### 5. **Filtering & Sorting** 🔍
- Sort by: votes, rating, comments, newest
- Filter by: status, rating, date range
- Search: kata kunci dalam aspirasi

---

## User Stories

### Student Journey
```
1. ✍️ Saya membuat aspirasi baru dengan saran saya
2. 👍 Saya vote aspirasi teman yang saya setujui
3. 💬 Saya komentar untuk menambah feedback
4. 📊 Saya lihat aspirasi saya sedang trending
5. 🔔 Saya notif BEM memberikan response
6. ✅ Saya lihat aspirasi saya sudah direalisasikan
7. 😊 Saya merasa didengar oleh BEM!
```

### BEM Journey
```
1. 📈 Saya lihat dashboard aspirasi populer
2. 🔍 Saya baca aspirasi secara detail
3. 💭 Saya diskusikan dengan tim BEM lainnya
4. ✍️ Saya tulis response & update status
5. 📢 Mahasiswa bisa lihat perkembangan aspirasi
6. 📊 Saya track aspirasi mana yang paling impact
```

---

## Admin Dashboard untuk Aspirasi (Future)

```
├─ Total Aspirasi
├─ Aspirasi Terbaru
├─ Top 5 Aspirasi Populer (by votes)
├─ Status Distribution (pie chart)
│  ├─ Submitted
│  ├─ Being Considered
│  └─ Realized
├─ Top Commenters
├─ Most Voted Aspirasi
└─ Engagement Stats
   ├─ Average votes per aspirasi
   ├─ Average comments per aspirasi
   └─ Response time (time to first BEM response)
```

---

## Implementation Checklist

- [x] Database migration untuk aspirasi enhancements
- [x] Update Aspirasi model dengan fields baru
- [x] Admin Dashboard (view stats)
- [ ] Vote system (like/unlike aspirasi)
- [ ] Comment system (comment pada aspirasi)
- [ ] Admin Aspirasi management page
  - [ ] View all aspirasi
  - [ ] Filter by status
  - [ ] Update status & response
- [ ] Aspirasi detail page (student view)
- [ ] Sorting & filtering pada aspirasi list
- [ ] Notification system (BEM update notif)
- [ ] Export aspirasi data (for reporting)

---

## Notes

- Aspirasi system mengedukasi mahasiswa untuk aktif berpartisipasi
- BEM bisa transparent tentang aspirasi yang mereka terima & aksi yang diambil
- Vote & comment system meningkatkan engagement & community participation
- Status tracking membuat aspirasi tidak hanya "masuk & lupa" tapi ada follow-up

