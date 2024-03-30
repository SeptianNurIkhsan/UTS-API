@extends('layouts.app')

@section('content')
    <header>
        <h1>Welcome to the Dashboard</h1>
        <nav>
            <ul>
                <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li><a href="{{ route('profile') }}">Profile</a></li>
                <li><a href="{{ route('contacts.create') }}">Contact</a></li>
                <li><a href="{{ route('addresses.create') }}">Address</a></li>
                <li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit">Logout</button>
                    </form>
                </li>
            </ul>
        </nav>
    </header>

    <main>
        <!-- Konten utama dashboard -->
        <h2>Add Contact</h2>
        <div id="add-contact-form">
            <form method="POST" action="{{ route('contacts.store') }}">
                @csrf

                <div class="form-group">
                    <label for="first_name">First Name:</label>
                    <input type="text" id="first_name" name="first_name">
                </div>

                <div class="form-group">
                    <label for="last_name">Last Name:</label>
                    <input type="text" id="last_name" name="last_name">
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email">
                </div>

                <div class="form-group">
                    <label for="phone">Phone:</label>
                    <input type="text" id="phone" name="phone">
                </div>

                <button type="submit">Add Contact</button>
            </form>
        </div>

        <!-- Daftar Kontak -->
        <h2>Contact List</h2>
        <ul id="contact-list">
            @isset($contacts)
                @forelse($contacts as $contact)
                    <li>
                        <p>Name: {{ $contact->first_name }} {{ $contact->last_name }}</p>
                        <p>Email: {{ $contact->email }}</p>
                        <p>Phone: {{ $contact->phone }}</p>
                    </li>
                @empty
                    <li>No contacts found.</li>
                @endforelse
            @else
                <li>No contacts found.</li>
            @endisset
        </ul>

        <!-- Form Tambah Alamat -->
        <h2>Add Address</h2>
        <div id="add-address-form">
            <form method="POST" action="{{ route('addresses.create') }}">
                @csrf

                <div class="form-group">
                    <label for="street">Street:</label>
                    <input type="text" id="street" name="street">
                </div>

                <div class="form-group">
                    <label for="city">City:</label>
                    <input type="text" id="city" name="city">
                </div>

                <div class="form-group">
                    <label for="province">Province:</label>
                    <input type="text" id="province" name="province">
                </div>

                <div class="form-group">
                    <label for="country">Country:</label>
                    <input type="text" id="country" name="country">
                </div>

                <div class="form-group">
                    <label for="postal_code">Postal Code:</label>
                    <input type="text" id="postal_code" name="postal_code">
                </div>

                <button type="submit">Add Address</button>
            </form>
        </div>

        <!-- Daftar Alamat -->
        <h2>Address List</h2>
        <ul id="address-list">
            @isset($addresses)
                @forelse($addresses as $address)
                    <li>
                        <p>Street: {{ $address->street }}</p>
                        <p>City: {{ $address->city }}</p>
                        <p>Province: {{ $address->province }}</p>
                        <p>Country: {{ $address->country }}</p>
                        <p>Postal Code: {{ $address->postal_code }}</p>
                    </li>
                @empty
                    <li>No addresses found.</li>
                @endforelse
            @else
                <li>No addresses found.</li>
            @endisset
        </ul>
    </main>

    <footer>
        <p>Copyright &copy; 2024 Our App</p>
    </footer>
@endsection
