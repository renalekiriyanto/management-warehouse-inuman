@extends('layouts.app')

@section('content')
    <div class="dashboard">

        <div class="metrics-grid">

            <div class="metric-card">
                <h4>Total Slot</h4>
                <h2>128</h2>
            </div>

            <div class="metric-card">
                <h4>Waiting</h4>
                <h2>32</h2>
            </div>

            <div class="metric-card">
                <h4>Inbound</h4>
                <h2>56</h2>
            </div>

            <div class="metric-card">
                <h4>Outbound</h4>
                <h2>40</h2>
            </div>

        </div>

        <div class="split-grid">

            <div class="panel">

                <h3>Today's Schedule</h3>

            </div>

            <div class="panel">

                <h3>Recent Activity</h3>

            </div>

        </div>

    </div>
@endsection
