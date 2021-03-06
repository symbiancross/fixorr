<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Validation\Rule;
use Auth;
use GeneaLabs\LaravelMaps\Facades\Map;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('web');
    }

    public function showEditUserForm()
    {
        $user = Auth::user();
        $config = array();
        $config['center'] = 'Wisma tengger';
        $config['map_height'] = '0px';
        $config['places'] = TRUE;
        $config['placesAutocompleteInputID'] = 'alamat';
        $config['placesAutocompleteBoundsMap'] = TRUE; // set results biased towards the maps viewport
        $config['placesAutocompleteOnChange'] = 'createMarker_map({ map: map, position:event.latLng });';
        Map::initialize($config);

        $map = Map::create_map();
        
        return view('auth.edit-user')->with('user', $user)->with('map', $map);;
    }

    public function update(Request $request, User $user)
    {
        $this->validate(request(), [
            'name' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'email' => 'required', Rule::unique('users')->ignore($user->id, 'user_id'),
            'telephone' => 'required|string|min:6',
            'password' => 'required|string|min:6|confirmed',
            'foto' => 'image|mimes:jpeg,png,jpg|max:500|dimensions:min_width=100,min_height=100,max_width=200,max_height=200',
        ]);

        if(!$request->foto==NULL)
        {
            $file = $request->file('foto');
            $fileName = $file->getClientOriginalName();
            $request->file('foto')->move("image/", $fileName);
            $user->foto = $fileName;
        }
        $user->nama = request('name');
        $user->alamat = request('alamat');
        $user->email = request('email');
        $user->no_telp = request('telephone');
        $user->password = bcrypt(request('password'));
        
        $user->save();

        return redirect('home')->with('success', 'Profil anda berhasil dirubah');
    }
}
