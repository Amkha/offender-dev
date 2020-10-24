const Welcome = () => import('~/pages/welcome').then(m => m.default || m)
const Login = () => import('~/pages/auth/login').then(m => m.default || m)
const Register = () => import('~/pages/auth/register').then(m => m.default || m)
const PasswordEmail = () => import('~/pages/auth/password/email').then(m => m.default || m)
const PasswordReset = () => import('~/pages/auth/password/reset').then(m => m.default || m)
const NotFound = () => import('~/pages/errors/404').then(m => m.default || m)

const Home = () => import('~/pages/home').then(m => m.default || m)
const Settings = () => import('~/pages/settings/index').then(m => m.default || m)
const SettingsProfile = () => import('~/pages/settings/profile').then(m => m.default || m)
const SettingsPassword = () => import('~/pages/settings/password').then(m => m.default || m)
const UserManagement = () => import('~/pages/settings/usermanagement').then(m => m.default || m)

//----- amkha ------------------
const About = () => import('~/pages/about').then(m => m.default || m)
const Offender = () => import('~/components/offender/index').then(m => m.default || m)
const OffenderProfile = () => import('~/components/offender/Profile').then(m => m.default || m)
const OffenderBusiness = () => import('~/components/offender/Business').then(m => m.default || m)
const OffenderNetwork = () => import('~/components/offender/Network').then(m => m.default || m)
const OffenderSearch = () => import('~/components/offender/OffenderSearch').then(m => m.default || m) 
const ProfileDetail = () => import('~/components/offender/ProfileDetail').then(m => m.default || m)

export default [
  { path: '/', name: 'welcome', component: Welcome },
  { path: '/about', name: 'about', component: About },

  { path: '/login', name: 'login', component: Login },
  { path: '/register', name: 'register', component: Register },
  { path: '/password/reset', name: 'password.request', component: PasswordEmail },
  { path: '/password/reset/:token', name: 'password.reset', component: PasswordReset },
  { path: '/usermanagement', name: 'usermanagement', component: UserManagement },

  { path: '/home', name: 'home', component: Home },
  { path: '/settings',
    component: Settings,
    children: [
      { path: '', redirect: { name: 'settings.profile' } },
      { path: 'profile', name: 'settings.profile', component: SettingsProfile },
      { path: 'password', name: 'settings.password', component: SettingsPassword }
    ] },
  { path: '/offender',
    component: Offender,
    children: [
      { path: '', redirect: { name: 'offender.profile' } },
      { path: 'profile', name: 'offender.profile', component: OffenderProfile },
      { path: 'business', name: 'offender.business', component: OffenderBusiness },
      { path: 'network', name: 'offender.network', component: OffenderNetwork },
      { path: 'offendersearch', name: 'offender.offendersearch', component: OffenderSearch },
      { path: 'profiledetail', name: 'offender.profiledetail', component: ProfileDetail, props: true },
    ] },
  { path: '*', component: NotFound }
]
