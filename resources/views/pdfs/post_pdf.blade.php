<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        section {
            margin-top: 20px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .tags {
            margin-bottom: 10px;
        }

        .tag-box {
            display: inline-block;
            background-color: #007bff;
            color: #fff;
            padding: 5px 10px;
            border-radius: 5px;
            margin-right: 5px;
            margin-bottom: 5px;
            cursor: pointer;
        }

        .description {
            margin-bottom: 20px;
        }

        .image-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 10px;
        }

        .image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 8px;
        }
    </style>
</head>
@php
    use App\Models\File;
    use Illuminate\Support\Facades\Storage;
@endphp
<body>
    <header>
        <h1>{{ $post->title }}</h1>
    </header>

    <section>
        <div class="tags">
            @foreach ($post->tags as $tag)
                <div class="tag-box">{{ $tag->name }}</div>
            @endforeach
        </div>

        <div class="description">
            <p>{{ $post->description }}</p>
        </div>

        <div class="image-grid">

            @foreach ($post->files as $file)
                @if ($file->type == File::PHOTO)
                    {{-- <img class="image" src="{{ Storage::url($file->file_path) }}" alt="{{ $file->file_path }}"> --}}
                    <img class="image" src="{{ $file->file_path }}" alt="{{ $file->file_path }}">
                @endif
            @endforeach
        </div>
    </section>
</body>
</html>
