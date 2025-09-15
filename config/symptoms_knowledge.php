<?php
// config/symptoms_knowledge.php

return [
    'sakit gigi' => [
        'response' => 'Gejala sakit gigi biasanya ditangani di Poli Gigi. Jika nyeri hebat atau ada pembengkakan, segera periksa ke dokter gigi.',
        'severity' => 'moderate',
        'department' => 'Poli Gigi',
    ],
    'demam' => [
        'response' => 'Demam bisa disebabkan banyak hal. Jika suhu di atas 38°C selama lebih dari 2 hari, silakan periksa ke Poli Umum.',
        'severity' => 'mild',
        'department' => 'Poli Umum',
    ],
    'nyeri dada' => [
        'response' => 'Nyeri dada bisa menjadi tanda penyakit serius. Segera periksa ke IGD atau Poli Jantung untuk penanganan cepat.',
        'severity' => 'severe',
        'department' => 'IGD / Kardiologi',
    ],
    'sesak napas' => [
        'response' => 'Sesak napas bisa berbahaya. Segera menuju IGD untuk pemeriksaan darurat.',
        'severity' => 'severe',
        'department' => 'IGD',
    ],
];
