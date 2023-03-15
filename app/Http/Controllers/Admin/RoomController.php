<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RoomController extends Controller
{
    public function index(Request $request)
    {$this->authorize('viewAny', Room::class);
        $search = $request->key ?? '';
        $name = $request->name ?? '';
        $id = $request->id ?? '';
        $orderby = $request->orderby ?? '';
        $query = Room::query(true);

        if (!empty($id)) {
            $query->where('id', $request->id);
        };
        if (!empty($orderby)) {
            $query->orderBy('id', $orderby);
        }
        if (!empty($name)) {
            $query->where('name', 'like', '%' . $name . '%');
        }
        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            });
        }
        $rooms = $query->paginate(5);
        $params = [
            'rooms' => $rooms,
        ];
        return view('admin.rooms.index', $params);
    }

    public function create()
    {
        $this->authorize('create', Room::class);
        return view('admin.rooms.create');
    }

    public function store(StoreRoomRequest $request)
    {
        $this->authorize('create', Room::class);
        try {
            $room = new Room();
            $room->name = $request->name;
            $room->description = $request->description;
            $room->save();
            return redirect()->route('rooms.index')->with('success', 'Thêm tài lớp học thành công.');
        } catch (\Exception $e) {
            if (isset($path)) {
                Log::error('message: ' . $e->getMessage() . ' line: ' . $e->getLine() . ' file: ' . $e->getFile());
                return back()->withInput()->with('error', 'Thêm lớp học không thành công!.');
            }
        }
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        $this->authorize('update', Room::class);
        $room = Room::find($id);
        $params = [
            'room' => $room,
        ];
        return view('admin.rooms.edit', $params);
    }

    public function update(UpdateRoomRequest $request, $id)
    {
        $this->authorize('update', Room::class);
        try {
            $Room = Room::find($id);
            $Room->name = $request->name;
            $Room->description = $request->description;
            $Room->save();
            return redirect()->route('rooms.index')->with('success', 'Cập nhật lớp học thành công.');
        } catch (\Exception$e) {
            Log::error('message: ' . $e->getMessage() . ' line: ' . $e->getLine() . ' file: ' . $e->getFile());
            return back()->withInput()->with('error', 'Cập nhật lớp học không thành công!.');
        }
    }

    public function destroy($id)
    {
        $this->authorize('delete', Room::class);
        try {
            $room = Room::find($id);
            $room->delete();
            return back()->with('success', 'Xóa lớp học thành công!.');
        } catch (\Exception $e) {
            Log::error('message: ' . $e->getMessage() . ' line: ' . $e->getLine() . ' file: ' . $e->getFile());
            return back()->with('error', 'Xóa lớp học không thành công!.');
        }

    }
}
