<?php # 03/05/2025
class Model
{
    public string $file;
    public array $data;

    public function Read(string $file, array $data = null)
    {
        $file = str_replace([".json", ".php", "../", "database/"], "", $file);
        $file = str_replace("./", "", $file);
        $filePath = $file;
        if (substr($file, 0, 4) != "http") {
            $filePath = __DIR__ . "/../../database/{$file}.json";
            if (!file_exists($filePath)) {
                return [];
            }
        }

        $fileRead = file_get_contents($filePath);
        return json_decode($fileRead, true) ?? [];
    }

    public function Save(string $file, array $data){
        $file = str_replace([".json", ".php", "../", "database/"], "", $file);
        $file = str_replace("./", "", $file);
        $file = $file[-1] == "/" ? substr($file, 0, strlen($file)-1) : $file;
        $file = $file . ".json";
        $route = RAIZ . "database/$file";
        $dirname = dirname($file) != "." ? dirname($file) . "/" : "";
        $basename = basename($file);
        if(!empty($dirname)){ Daamper::$scripts->CrearCarpetas("database/$dirname"); }
        return file_put_contents($route, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    public function Post(string $file, array $data = null)
    {
        return $this->Read("post/" . $file, $data);
    }

    public function User(string $file = "user", array $data = null)
    {
        return $this->Read("user/" . $file, $data);
    }

    public function UserRoute(bool $extras = false, bool $dir__database = true)
    {
        return ($dir__database ? __DIR__ . "/../../database/" : "") . "user/" . ($extras ? "extras" : "user")  . ".json";
    }

    public function UserAll()
    {
        return Daamper::$scripts->UnirArrays($this->User(), $this->User("extras") ?? []);
    }

    public function UserByID(int $id)
    {
        return $this->UserAll()[$id];
    }

    public function UserByUser(string $user)
    {
        foreach ($this->UserAll() as $id => $data) {
            if ($user == $data["usuario"]) {
                return $data;
            }
        }
        return;
    }

    public function InsertUser(array $data)
    {
        $users = $this->UserAll();
        $users_quantity = count($users);
        $users_new_id = $users_quantity + 1;
        $data["id"] = $users_new_id;
        $users[$users_new_id] = $data;
        return $this->Save($this->UserRoute(false, false), $users);
    }

    public function UpdateUser(array $data, bool $extras = false)
    {
        return $this->Save($this->UserRoute($extras, false), $data);
    }

    public function CommentRoute(bool $extras = false, bool $dir__database = true)
    {
        return ($dir__database ? __DIR__ . "/../../database/" : "") . "comment/" . ($extras ? "extras" : "comment")  . ".json";
    }

    public function Comment(string $file = "comment", array $data = null)
    {
        return $this->Read("comment/" . $file, $data);
    }

    public function CommentAll()
    {
        $user = $this->Read("comment/comment");
        $user_extras = $this->Read("comment/extras") ?? [];
        return Daamper::$scripts->UnirArrays($user, $user_extras);
    }

    public function UpdateComment(array $data, bool $extras = false)
    {
        return $this->Save($this->CommentRoute($extras, false), $data);
    }

    public function Config(string $file = "config", array $data = null)
    {
        return $this->Read("config/" . $file, $data);
    }

    public function Other(string $file, array $data = null)
    {
        return $this->Read("other/" . $file, $data);
    }

    public function Creator(string $file, array $data = null)
    {
        return $this->Read("creator/" . $file, $data);
    }

    public function CreateEntry(string $route, string $directorio = "./")
    {
        return Daamper::$scripts->CreateEntry($route, $directorio);
    }
}

Daamper::$data = new Model;