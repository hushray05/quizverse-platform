# QuizVerse AGENT.md - Production Rules

ROLE: Staff Engineer / Tech Lead, 12+ yrs, FAANG code review level.

PROJECT: QuizVerse Laravel Quiz Platform. Raw HTML in /raw_html/ is REFERENCE ONLY - you have full permission to RE-DESIGN to 2026 standard (vercel.com, linear.app, react.dev).

DESIGN 2026 MANDATORY:
- Dark-first zinc-950/slate-950, glassmorphism, bento-box, mesh gradients
- Fonts: Inter + JetBrains Mono via NPM (@fontsource/*) NOT CDN
- Components: rounded-[20px], border-zinc-800/60, backdrop-blur-xl, shadow-[0_0_0_1px_rgba(255,255,255,0.08)], hover:scale-[1.02]
- Collapsible sidebar like Next.js docs, premium cards not AI templates

OFFLINE ICONS - NO CDN (CRITICAL):
- Install: npm install @fortawesome/fontawesome-free bootstrap-icons devicon sweetalert2 chart.js @fontsource/inter @fontsource/jetbrains-mono lucide
- Bundle: @import in app.css + import in app.js + vite build
- ICONS EVERYWHERE: sidebar, cards, buttons, empty states, tables. Mix packs (FA for actions, BI for UI, Devicon for categories). COLORED icons (text-violet-400 text-[20px]) not monochrome.

ALERTS: Never use alert()/confirm(). Use SweetAlert2 offline: window.Swal.

BUILD: Layouts (app, guest, player, creator, admin), Components (navbar, sidebar, bento-card, stat-metric, quiz-card, empty-state, data-table), Models with relations, Controllers single responsibility, Services (QuizService scoring = base+time+streak, LeaderboardService), Migrations with FK/indexes, Seeders realistic.

FEATURES ALL WORKING: Player (overview XP/level, explore filter, category, quick/challenge/daily, gameplay timer, results, profile, leaderboard), Creator (question bank CRUD search bulk, editor, quiz mgmt, category), Admin (overview, users ban/role, RBAC, settings, audit logs, analytics Chart.js offline, campaigns/ads). Add empty states, skeletons, 404/403, validation, responsive, pagination.

QA: npm run build offline check, migrate:fresh --seed, route:list fix, no CDN remain, update PROJECT_STATUS.md

EXECUTION: Batch writes to save quota, no questions, re-design ugly templates, build end-to-end.