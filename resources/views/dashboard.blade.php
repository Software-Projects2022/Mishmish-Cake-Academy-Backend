@extends('layouts.app')

@section('content')
<div class="container">
    <div class="container_profil">
        <div class="header">
            <div class="profile-section">
                <div class="avatar">م</div>
                <div class="profile-info">
                    <h1>
                        {{ auth()->guard('client')->user()->name }}
                        <span class="active-badge">نشط</span>
                    </h1>
                    <div class="profile-meta">
                        <span class="meta-item"> • {{ auth()->guard('client')->user()->email }}</span>
                    </div>
                </div>
            </div>

            <div class="info-row">
                <div class="info-item">
                    <i class="fas fa-calendar-alt"></i>
                    @php
                        \Carbon\Carbon::setLocale('ar');
                    @endphp

                    انضم في {{ auth()->guard('client')->user()->created_at->isoFormat('D MMMM YYYY') }}

                </div>
                <div class="info-item">
                    <i class="fas fa-check-circle"></i>
                    {{-- حضر منذ {{ auth()->user()->created_at->diffForHumans() }} --}}
                </div>
            </div>

            {{-- <div class="tags">
                <span class="tag">كيك فاخر</span>
                <span class="tag">تزيين الكيك</span>
            </div> --}}

            <div class="contact-row">
                <div class="contact-item">
                    <i class="fas fa-envelope"></i>
                    {{ auth()->guard('client')->user()->email }}
                </div>
                <div class="contact-item">
                    <i class="fas fa-phone"></i>
                    {{ auth()->guard('client')->user()->phone }}
                </div>
            </div>
        </div>

        <div class="programs-section">
            <h2 class="section-title">الكورسات</h2>
            <div class="programs-grid">

                @foreach (auth()->guard('client')->user()->bookings as $booking)


                @if ($booking->status == 'approved')
                <a href="{{ route('course.show', $booking->course->id) }}">
                @endif
                <div class="program-card {{ $booking->status == 'approved' ? 'active' : 'cancelled' }}">
                    <button class="menu-btn"><i class="fas fa-ellipsis-v"></i></button>
                    <div class="program-status {{ $booking->status == 'approved' ? 'active' : 'cancelled' }}">

                        @if ($booking->status == 'approved')
                        <span class="status-dot active"> </span>نشط
                        @elseif ($booking->status == 'pending')
                        <span class="status-dot cancelled"> </span>معلق
                        @elseif ($booking->status == 'rejected')
                        <span class="status-dot cancelled"> </span>ملغي
                        @endif
                    </div>
                    <div class="program-title">{{ $booking->course->title }}</div>
                    <div class="program-time">تاريخ التسجيل: {{ $booking->created_at->isoFormat('D MMMM YYYY') }}</div>
                </div>
                @if ($booking->status == 'approved')
                    </a>
                @endif

                @endforeach


            </div>
        </div>

        {{-- <div class="tabs">
            <div class="tab active" data-tab="activity">النشاط</div>
            <div class="tab" data-tab="payments">المدفوعات</div>
            <div class="tab" data-tab="attendance">سجل الحضور</div>
            <div class="tab" data-tab="documents">المستندات</div>
            <div class="tab" data-tab="family">العائلة (4)</div>
        </div>

        <div class="tab-content active" id="activity">
            <div class="activity-section">
                <div class="activity-item">
                    <div class="activity-icon check">
                        <i class="fas fa-check"></i>
                    </div>
                    <div class="activity-content">
                        <div class="activity-time">3:00 مساءً، 20 ديسمبر 2025</div>
                        <div class="activity-text">
                            تم تسجيل الحضور في كورس <strong>الكيك الفرنسي المتقدم</strong>
                        </div>
                    </div>
                </div>

                <div class="activity-item">
                    <div class="activity-icon payment">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="activity-content">
                        <div class="activity-time">2:30 مساءً، 15 ديسمبر 2025</div>
                        <div class="activity-text">
                            تم دفع مبلغ <strong>2500 جنيه</strong> لكورس <strong>الكيك الفرنسي المتقدم</strong>
                            بواسطة
                            <span class="highlight">شارلوت بيل</span>
                        </div>
                    </div>
                </div>

                <div class="activity-item">
                    <div class="activity-icon email">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="activity-content">
                        <div class="activity-time">10:00 صباحاً، 10 ديسمبر 2025</div>
                        <div class="activity-text">
                            تم إرسال بريد إلكتروني عن <strong>جدول الكورسات</strong> لشهر يناير
                        </div>
                    </div>
                </div>

                <div class="activity-item">
                    <div class="activity-icon check">
                        <i class="fas fa-check"></i>
                    </div>
                    <div class="activity-content">
                        <div class="activity-time">2:00 مساءً، 5 نوفمبر 2025</div>
                        <div class="activity-text">
                            تم تسجيل الحضور في كورس <strong>الكب كيك والمافن</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tab-content" id="payments">
            <div class="activity-section">
                <div class="payment-item">
                    <div class="payment-info">
                        <h4>كورس الكيك الفرنسي المتقدم</h4>
                        <p>15 ديسمبر 2025 • بواسطة شارلوت بيل</p>
                    </div>
                    <div class="payment-amount">2500 جنيه</div>
                </div>
                <div class="payment-item">
                    <div class="payment-info">
                        <h4>كورس الكب كيك والمافن</h4>
                        <p>5 نوفمبر 2025 • بواسطة شارلوت بيل</p>
                    </div>
                    <div class="payment-amount">1800 جنيه</div>
                </div>
                <div class="payment-item">
                    <div class="payment-info">
                        <h4>كورس تزيين الكيك للمبتدئين</h4>
                        <p>20 سبتمبر 2025 • بواسطة شارلوت بيل</p>
                    </div>
                    <div class="payment-amount">1500 جنيه</div>
                </div>
            </div>
        </div>

        <div class="tab-content" id="attendance">
            <div class="activity-section">
                <table class="attendance-table">
                    <thead>
                        <tr>
                            <th>الكورس</th>
                            <th>التاريخ</th>
                            <th>الوقت</th>
                            <th>الحالة</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>كورس الكيك الفرنسي المتقدم</td>
                            <td>20 ديسمبر 2025</td>
                            <td>3:00 - 6:00 مساءً</td>
                            <td><span class="status-badge present">حضر</span></td>
                        </tr>
                        <tr>
                            <td>كورس الكيك الفرنسي المتقدم</td>
                            <td>13 ديسمبر 2025</td>
                            <td>3:00 - 6:00 مساءً</td>
                            <td><span class="status-badge present">حضر</span></td>
                        </tr>
                        <tr>
                            <td>كورس الكب كيك والمافن</td>
                            <td>5 نوفمبر 2025</td>
                            <td>2:00 - 5:00 مساءً</td>
                            <td><span class="status-badge present">حضر</span></td>
                        </tr>
                        <tr>
                            <td>كورس الكب كيك والمافن</td>
                            <td>29 أكتوبر 2025</td>
                            <td>2:00 - 5:00 مساءً</td>
                            <td><span class="status-badge absent">غائب</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="tab-content" id="documents">
            <div class="activity-section">
                <div class="empty-state">
                    <i class="fas fa-file-alt"></i>
                    <h3>لا توجد مستندات</h3>
                    <p>لم يتم رفع أي مستندات حتى الآن</p>
                </div>
            </div>
        </div>

        <div class="tab-content" id="family">
            <div class="activity-section">
                <div class="empty-state">
                    <i class="fas fa-users"></i>
                    <h3>معلومات العائلة</h3>
                    <p>4 أفراد مسجلين في النظام</p>
                </div>
            </div>
        </div> --}}
    </div>

</div>

@endsection
