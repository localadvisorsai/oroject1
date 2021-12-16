<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait CallByName
{
    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
     
    public function call(Request $request, $method) {
        return $this->{$method}($request);
    }
}
