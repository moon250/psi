@extends('template')
@section('title') Blacklist @endsection

@section('body')
    <main class="blacklist__wrapper">
        <a href="{{ back()->getTargetUrl() }}">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 2C6.5 2 2 6.5 2 12C2 17.5 6.5 22 12 22C17.5 22 22 17.5 22 12C22 6.5 17.5 2 12 2ZM15 13H11.4L12.7 14.3C13.1 14.7 13.1 15.3 12.7 15.7C12.3 16.1 11.7 16.1 11.3 15.7L8.3 12.7C7.9 12.3 7.9 11.7 8.3 11.3L11.3 8.3C11.7 7.9 12.3 7.9 12.7 8.3C13.1 8.7 13.1 9.3 12.7 9.7L11.4 11H15C15.6 11 16 11.4 16 12C16 12.6 15.6 13 15 13Z" fill="currentColor"/>
            </svg>
            Go back
        </a>
        <h2>Blacklisted websites</h2>
        <table class="blacklist__table">
            <thead>
                <tr>
                    <th>Website</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($blacklist as $website)
                    <tr data-website="{{ $website }}">
                        <td>{{$website}}</td>
                        <td>
                            <svg onclick="removeFromBlacklist('{{ $website }}')" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="blacklist__action-delete">
                                <path d="M12 0C5.4 0 0 5.4 0 12C0 18.6 5.4 24 12 24C18.6 24 24 18.6 24 12C24 5.4 18.6 0 12 0ZM16.44 14.76C16.92 15.24 16.92 15.96 16.44 16.44C15.96 16.92 15.24 16.92 14.76 16.44L12 13.68L9.24 16.44C8.76 16.92 8.04 16.92 7.56 16.44C7.08 15.96 7.08 15.24 7.56 14.76L10.32 12L7.56 9.24C7.08 8.76 7.08 8.04 7.56 7.56C8.04 7.08 8.76 7.08 9.24 7.56L12 10.32L14.76 7.56C15.24 7.08 15.96 7.08 16.44 7.56C16.92 8.04 16.92 8.76 16.44 9.24L13.68 12L16.44 14.76Z" fill="currentColor"/>
                            </svg>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </main>

    <script>
        removeFromBlacklist = async (website) => {
            await fetch('/api/blacklist', {
                method: 'DELETE',
                body: JSON.stringify({
                    website
                }),
            })

            document.querySelectorAll(`[data-website="${website}"]`).forEach(e => e.remove())
        }
    </script>
@endsection
