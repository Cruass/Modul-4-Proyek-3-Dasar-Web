<?php

namespace App\Http\Controllers;
use App\Models\Category;
use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use App\Models\Activity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivityController extends Controller
{
    public function index(Request $request): View
    {
        $query = Activity::with('category');

        if ($request->filled('search')) {
            $query->where('code', 'like', '%' . $request->search . '%')
                  ->orWhere('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $sort = $request->query('sort', 'desc'); 
        $query->orderBy('activity_date', $sort);

        $activities = $query->paginate(5)->withQueryString();
        
        $categories = Category::all();

        return view('activities.index', compact('activities', 'categories'));
    }

    public function publish(Activity $activity)
    {
        if (empty($activity->title) || strlen($activity->title) < 10) {
            return redirect()->back()->with('error', 'Gagal: Draft tidak lengkap (judul minimal 10 karakter) tidak dapat dipublikasikan!');
        }

        $activity->update(['status' => 'Published']);

        return redirect()->route('activities.index')->with('success', 'Kegiatan berhasil dipublikasikan!');
    }

    public function complete(Activity $activity)
    {
        // Business Rule: Hanya status Published yang boleh ke Completed
        if ($activity->status !== 'Published') {
            return redirect()->back()->with('error', 'Gagal: Hanya kegiatan berstatus Published yang dapat diselesaikan!');
        }

        $activity->update(['status' => 'Completed']);

        return redirect()->route('activities.index')->with('success', 'Kegiatan berhasil diselesaikan!');
    }

    public function create()
    {
        $categories = Category::all();
        return view('activities.create', compact('categories'));
    }

    public function store(StoreActivityRequest $request): RedirectResponse
    {
        Activity::create($request->validated());

        return redirect()->route('activities.index')->with('success', 'Kegiatan berhasil ditambahkan!');
    }

    public function show(Activity $activity): View
    {
        return view('activities.show', compact('activity'));
    }

    public function edit(Activity $activity)
    {
        $categories = Category::all();
        return view('activities.edit', compact('activity', 'categories'));
    }

    public function update(UpdateActivityRequest $request, Activity $activity): RedirectResponse
    {
        // Business Rule Guard: Cegah transisi ilegal dari Completed ke Draft
        if ($activity->status === 'Completed' && $request->status === 'Draft') {
            return redirect()->back()->with('error', 'Gagal: Kegiatan yang sudah Completed tidak boleh dikembalikan ke Draft!');
        }

        $activity->update($request->validated());

        return redirect()->route('activities.index')->with('success', 'Kegiatan berhasil diperbarui!');
    }

    public function destroy(Activity $activity)
    {
        $activity->delete(); 
        return redirect()->route('activities.index')->with('success', 'Kegiatan berhasil dihapus.');
    }

    public function restore($id)
{
    $activity = Activity::onlyTrashed()->findOrFail($id);
    $activity->restore();

    return redirect()->route('activities.index')->with('success', 'Kegiatan berhasil direstore.');
}

public function trash()
{
    $activities = Activity::onlyTrashed()->paginate(5);
    return view('activities.trash', compact('activities'));
}

}