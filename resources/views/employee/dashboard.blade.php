@extends('employee.layout')

@section('title', 'Employee Dashboard')
@section('page_title', 'Dashboard')

@section('content')
    <div>
        <h2 class="text-3xl font-bold text-[#1f2b5d]">Welcome back, Ian!</h2>
        <p class="text-sm text-slate-500">Here is an overview of your HR information.</p>
    </div>

    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
        <article class="rounded-2xl border border-slate-300 bg-white p-5 shadow-sm">
            <p class="text-xs font-medium text-slate-500">Active Credentials</p>
            <p class="mt-1 text-4xl font-extrabold">0</p>
            <p class="text-xs text-slate-500">0 pending review</p>
        </article>
        <article class="rounded-2xl border border-slate-300 bg-white p-5 shadow-sm">
            <p class="text-xs font-medium text-slate-500">Compliance</p>
            <p class="mt-1 text-4xl font-extrabold">0/0</p>
            <p class="text-xs text-slate-500">Up to date</p>
        </article>
        <article class="rounded-2xl border border-slate-300 bg-white p-5 shadow-sm">
            <p class="text-xs font-medium text-slate-500">Leave Balance</p>
            <p class="mt-1 text-4xl font-extrabold">0</p>
            <p class="text-xs text-slate-500">Total days remaining</p>
        </article>
        <article class="rounded-2xl border border-slate-300 bg-white p-5 shadow-sm">
            <p class="text-xs font-medium text-slate-500">Notifications</p>
            <p class="mt-1 text-4xl font-extrabold">3</p>
            <p class="text-xs text-slate-500">Recent alerts</p>
        </article>
    </div>

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
        <div class="space-y-6 xl:col-span-2">
            <article class="rounded-2xl border border-slate-300 bg-white p-6 shadow-sm">
                <h3 class="text-2xl font-bold text-slate-800">Compliance Status</h3>
                <div class="mt-4 space-y-3">
                    <div class="flex items-center justify-between rounded-2xl border border-slate-200 bg-slate-50 px-5 py-3">
                        <p class="text-sm font-semibold text-slate-700">Compliant</p>
                        <p class="text-3xl font-extrabold text-emerald-500">0</p>
                    </div>
                    <div class="flex items-center justify-between rounded-2xl border border-slate-200 bg-slate-50 px-5 py-3">
                        <p class="text-sm font-semibold text-slate-700">Expiring Soon</p>
                        <p class="text-3xl font-extrabold text-amber-500">0</p>
                    </div>
                    <div class="flex items-center justify-between rounded-2xl border border-slate-200 bg-slate-50 px-5 py-3">
                        <p class="text-sm font-semibold text-slate-700">Non-Compliant</p>
                        <p class="text-3xl font-extrabold text-red-500">0</p>
                    </div>
                </div>
            </article>

            <article class="rounded-2xl border border-slate-300 bg-white p-6 shadow-sm">
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="text-2xl font-bold text-slate-800">Recent Alerts</h3>
                    <a href="{{ route('employee.notifications') }}" class="text-sm font-semibold text-blue-800 hover:underline">View All</a>
                </div>
                <div class="space-y-3">
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 px-5 py-4">
                        <p class="text-sm font-semibold">PRC License Renewal Reminder</p>
                        <p class="text-xs text-slate-500">Feb 12, 5:35 PM</p>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 px-5 py-4">
                        <p class="text-sm font-semibold">DTR Released: January 16-31</p>
                        <p class="text-xs text-slate-500">Feb 12, 5:35 PM</p>
                    </div>
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 px-5 py-4">
                        <p class="text-sm font-semibold">New Leave Policy Update</p>
                        <p class="text-xs text-slate-500">Feb 12, 5:35 PM</p>
                    </div>
                </div>
            </article>
        </div>

        <article class="rounded-2xl border border-slate-300 bg-white p-6 shadow-sm">
            <h3 class="text-2xl font-bold text-slate-800">System Calendar</h3>
            <p class="mt-3 text-sm font-semibold text-slate-700">February 2026</p>
            <div class="mt-4 grid grid-cols-7 gap-2 text-center text-sm text-slate-500">
                <span>Sun</span><span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span>
            </div>
            <div class="mt-2 grid grid-cols-7 gap-2 text-center text-sm">
                <span>1</span><span>2</span><span>3</span><span>4</span><span>5</span><span>6</span><span>7</span>
                <span>8</span><span>9</span><span>10</span><span>11</span><span>12</span><span class="font-bold text-blue-800">13</span><span>14</span>
                <span>15</span><span>16</span><span>17</span><span>18</span><span>19</span><span>20</span><span>21</span>
                <span>22</span><span>23</span><span>24</span><span>25</span><span>26</span><span>27</span><span>28</span>
            </div>
            <div class="mt-6 space-y-2 text-sm">
                <p class="font-semibold">UPCOMING EVENTS</p>
                <p class="text-slate-600">EDSA People Power Anniversary</p>
                <p class="text-slate-600">CHED Compliance Deadline</p>
                <p class="text-slate-600">Midterm Exams</p>
                <p class="text-slate-600">Faculty Development Seminar</p>
            </div>
        </article>
    </div>
@endsection