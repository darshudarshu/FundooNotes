<?php
/*******************************************************************
 * @discription API for labels
 ********************************************************************/

header('Access-Control-Allow-Origin: *');
header("Content-type: image/gif");
include "DatabaseConnection.php";
require 'JWT.php';

/**
 * class Api labeled notes contoller methods
 */

class LabelController
{
/**
 * @var string $connect PDO object
 */
/**
 * @var string $title title
 * @var string $notes notes
 * @var string $email email
 * @var string $color color
 * @var string $isArchive isArchive
 * @var string $label label
 * @var string $remainder remainder
 */
    public $connect = "";
/**
 * @method constructor to establish the database connection
 * @return void
 */
    public function __construct()
    {
        $ref           = new DatabaseConnection();
        $this->connect = $ref->Connection();
    }
/**
 * @method fetchLabelNote() fetch label notes
 * @return void
 */
    public function fetchLabelNote()
    {
        $headers = apache_request_headers();
        $token   = explode(" ", $headers['Authorization']);
        $label   = $_POST["label"];
        $email   = $_POST["email"];
        $reff    = new JWT();
        if ($reff->verify($token[1])) {
            /**
             * @var string $query has query to select all notes with label
             */
            $query = "SELECT * FROM notes where email='$email' and isDeleted='no' and label='$label'  order by dragId desc";
            /**
             * @var string $statement holds statement object
             */
            $statement = $this->connect->prepare($query);
            if ($statement->execute()) {
                /**
                 * @var array $arr to store result
                 */
                $arr = $statement->fetchAll(PDO::FETCH_ASSOC);
                /**
                 * returns json array response
                 */
                print json_encode($arr);

            } else {
                $data = array(
                    "error" => "404",
                );
                /**
                 * returns json array response
                 */
                print json_encode($data);
            }
        } else {
            $data = array(
                "error" => "404",
            );
            /**
             * returns json array response
             */
            print json_encode($data);
        }
    }
/**
 * @method changeLabelDateTime() change the label component data and time
 * @return void
 */
    public function changeLabelDateTime()
    {
        $ref             = new DatabaseConnection();
        $this->connect   = $ref->Connection();
        $id              = $_POST["id"];
        $label           = $_POST["label"];
        $email           = $_POST["email"];
        $presentDateTime = $_POST["presentDateTime"];
        $query           = "UPDATE notes SET remainder = '$presentDateTime' where id = '$id'";
        $statement       = $this->connect->prepare($query);
        if ($statement->execute()) {
            /**
             * @var string $query has query to select all notes from database
             */
            $query = "SELECT * FROM notes where email='$email' and isDeleted='no' and label='$label'  order by dragId desc";
            /**
             * @var string $statement holds statement object
             */
            $statement = $this->connect->prepare($query);
            if ($statement->execute()) {
                /**
                 * @var array $arr to store result
                 */
                $arr = $statement->fetchAll(PDO::FETCH_ASSOC);
                /**
                 * returns json array response
                 */
                print json_encode($arr);
            } else {
                $data = array(
                    "error" => "404",
                );
                /**
                 * returns json array response
                 */
                print json_encode($data);
            }
        } else {
            $data = array(
                "error" => "404",
            );
            /**
             * returns json array response
             */
            print json_encode($data);
        }
    }
/**
 * @method createLabelNotes() to create notes with labels
 * @return void
 */
    public function createLabelNotes()
    {
        $headers = apache_request_headers();
        $token   = explode(" ", $headers['Authorization']);
        $reff    = new JWT();
        if ($reff->verify($token[1])) {
            $title     = $_POST["title"];
            $notes     = $_POST["notes"];
            $email     = $_POST["email"];
            $color     = $_POST["color"];
            $isArchive = $_POST["isArchive"];
            $label     = $_POST["label"];
            $remainder = $_POST["remainder"];
            /**
             * @var string $query has query to Insert data into database (notes) table name
             */
            $query = "INSERT INTO notes (email,title,notes,remainder,isArchive,color,label) VALUES('$email','$title','$notes','$remainder','$isArchive','$color','$label')";
            /**
             * @var string $statement holds statement object
             */
            $statement = $this->connect->prepare($query);
            if ($statement->execute()) {
                /**
                 * @var string $query has query to select all notes
                 */
                $query = "SELECT * FROM notes where email='$email' and  isDeleted='no' and label='$label'  order by dragId desc";
                /**
                 * @var string $statement holds statement object
                 */
                $statement = $this->connect->prepare($query);
                if ($statement->execute()) {
                    /**
                     * @var array $arr to store result
                     */
                    $arr = $statement->fetchAll(PDO::FETCH_ASSOC);
                    /**
                     * returns json array response
                     */
                    print json_encode($arr);
                }
            } else {
                $data = array(
                    "error" => "202",
                );
                /**
                 * returns json array response
                 */
                print json_encode($data);
            }
        } else {
            $data = array(
                "error" => "404",
            );
            /**
             * returns json array response
             */
            print json_encode($data);
        }
    }
/**
 * @method deleteLabelNote() to delete the labeled notes
 * @return void
 */
    public function deleteLabelNote()
    {
        $headers = apache_request_headers();
        $token   = explode(" ", $headers['Authorization']);
        $reff    = new JWT();
        if ($reff->verify($token[1])) {
            $ref           = new DatabaseConnection();
            $this->connect = $ref->Connection();
            $id            = $_POST["id"];
            $label         = $_POST["label"];
            $email         = $_POST["email"];
            $query         = "UPDATE notes SET isDeleted = 'yes' where id = '$id'";
            $statement     = $this->connect->prepare($query);
            if ($statement->execute()) {
                /**
                 * @var string $query has query to select all the notes
                 */
                $query = "SELECT * FROM notes where email='$email' and isDeleted='no' and label='$label'  order by dragId desc";
                /**
                 * @var string $statement holds statement object
                 */
                $statement = $this->connect->prepare($query);
                if ($statement->execute()) {
                    /**
                     * @var array $arr to store result
                     */
                    $arr = $statement->fetchAll(PDO::FETCH_ASSOC);
                    /**
                     * returns json array response
                     */
                    print json_encode($arr);
                }
            } else {
                $data = array(
                    "error" => "202",
                );
                /**
                 * returns json array response
                 */
                print json_encode($data);
            }
        } else {
            $data = array(
                "error" => "404",
            );
            /**
             * returns json array response
             */
            print json_encode($data);
        }
    }
/**
 * @method deleteNoteLabels() to delete the notes label
 * @return void
 */
    public function deleteNoteLabels()
    {
        $ref           = new DatabaseConnection();
        $this->connect = $ref->Connection();
        $id            = $_POST["id"];
        $label         = $_POST["label"];
        $email         = $_POST["email"];
        $query         = "UPDATE notes SET label = null where id = '$id'";
        $statement     = $this->connect->prepare($query);
        if ($statement->execute()) {
            /**
             * @var string $query has query to select all the notes
             */
            $query = "SELECT * FROM notes where email='$email' and isDeleted='no' and label='$label'  order by dragId desc";
            /**
             * @var string $statement holds statement object
             */
            $statement = $this->connect->prepare($query);
            if ($statement->execute()) {
                /**
                 * @var array $arr to store result
                 */
                $arr = $statement->fetchAll(PDO::FETCH_ASSOC);
                /**
                 * returns json array response
                 */
                print json_encode($arr);
            }
        } else {
            $data = array(
                "error" => "202",
            );
            /**
             * returns json array response
             */
            print json_encode($data);
        }
    }
/**
 * @method fetchImage() fetch the user profile pic
 * @return void
 */
    public function fetchImage()
    {
        $email = $_POST["email"];
        /**
         * @var string $query has query to select the profile pic of the user
         */
        $query     = "SELECT profilepic FROM registration where email='$email'";
        $statement = $this->connect->prepare($query);
        if ($statement->execute()) {

            $arr = $statement->fetch(PDO::FETCH_ASSOC);
            /**
             * returns json array response
             */
            print json_encode($arr);
        }

    }
/**
 * @method saveImage() upload the profile pic
 * @return void
 */
    public function saveImage()
    {
        $ref           = new DatabaseConnection();
        $this->connect = $ref->Connection();

        $email  = $_POST["email"];
        $url    = $_POST["url"];
        $binary = base64_decode("9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBxMTEhUTExMWFRUXFxkYFhgXFxgYGBgYFxUXFxcXFhcYHSggGB0lHRcWITEhJSkrLi4uFx8zODMtNygtLisBCgoKDg0OGhAQFy0gHR8tLS0rKy0tKystKy0rLS0tLS0tLS0tLS8tKysrLSstLSstKy0tLS0tLS0tLS0tLTctLf/AABEIALcBEwMBIgACEQEDEQH/xAAcAAABBAMBAAAAAAAAAAAAAAADAgQFBgABBwj/xABUEAABAwEFAwcHBgkHCwUAAAABAgMRAAQSITFBBVFhBhMiMnGBkQcUobHB0fAjQlJyc7MVJDM1YrLC4fElQ1NjdIKSCBYXJjQ2g6K0w9JERVTT4v/EABoBAQEBAQEBAQAAAAAAAAAAAAABAgMEBQb/xAAoEQACAQMDAwQCAwAAAAAAAAAAAQIDETEEEiETQVEFImGRFIEyQuH/2gAMAwEAAhEDEQA/AOlPQD8caZFi8TmTH8Ipw2eOedIUYOBjdXkPYgbTRAxGNYpIO+aesrBkGm6UhSiZj05Z0QuIAikuGY9m6nSWJ9VaFn6WOXxFAR5bSRiNN098VF2lEGAZnGONTNpaVeO7h401tFm+crTxz1oVEe2cQknGak0gU28xIVMYe/sp6qzXR7apljRYnOPbUFtbrXdT7qsiLMMdN/7qgNqYOEHPMY+EVliJDttFJjDWprk8z+MswQDfGOcEg6a0ws4vKAOp+BVj2UyPOGSBEODLsINFksnwy7Fly+n5UZK+YN6eNco/ygkKCLJKr3Tc0AjoDHCuwK66exXrTXI/8oY9Cx/Xc/UFe1ZPGW3yVNr/AATYyFwObOF0fTVrVoYZcjFzU/MSNTVe8lH5osf2X7aqtLGXefWagAsNLuj5T/lG+vJ23h8vaJx+Xe++V4V63s56I+Na8j7fP4xaPt3vvlVYlR3fyHNk7KTCiBzz2ED6fEVfWmlY9M5nRPuqjeQv81I+1e+8NX5o59pqEBNtKjrnM6J39lefLv8ArGAT/wC4DHDQz7K9EoPrPrrzuj/eQf2/31UVHoF1pWHTV1honfllW3GlSnpqz3J3HhRHTl2j11tzTt9hrJDnnlwSfwejpE/jDW7cvhTnyNNn8GI6RHyjuAA/pDvFNvLqf5OR/aW/1XKeeRc/yW39o996qtdi9i5ttKx6aszonf2VpplUflFZnRG8/o0Zs+s+utNHDvPrrJDypa0/je0uAtM8fxtA9tdp8iliQrZaCUgnnXvvDXGLSr8a2p9W0f8AWt12/wAiH5qR9q996qtFZYLZYmktOKuAQv8AbAoVrdHzfj4FPNqn8Xc16f8A3BUKpZie0gcNBXCpk608BVqVNZQFumc61WLGyMY2gkxBxqSadSYkzOfhhXN7Pb8M86kbLtdQwk4+6jTLcvPPBKYnjhI+MjWrMsYqxMkAekmq23taQJ3VJ2S2gYDXHHfWTRP2VQmIPhrT20oBwOGH8Krtmt8EycTTov8A6RJjCqZaJMtiM9ScY+N1MbaBMCe0GlDK9Jyw3zrQiuAdd/GjCBFISJvGIrSVnu7KE88CMqT5xGWcQOyoaDPHHjrh2E1AcoEEpBu656zp2VZozwkaD9oduHhQNrIJQoJOBxjsGGJG+oEyrbGSSszonGePtqatCHgn8WAD8K5m9EX4wmcCO2hbKsgBUST1RhGuM1N2Nz5Vka3uGV3LCqskk+CpKY5UlQ6dlmDHUy6M/N7KpflMZ2skMfhNbShKua5uMDAvTAGleilddP1VetNck/yhB0bH9Zz9VNetZPIMORdl2+bEwbI7Z02e78kFkXgm8c+gdZ1qWasPKiMH7Nmcynf9nVt8lH5osf2X7SqtDGXefWaXBy1qwcpiBFosw7VD2NVxS3oVzjgWenzjgWcwV84bxGWEzur15ZeqPjU15L2r/tD32733qqqKXzyebL20uxg2G0tNMc44AlZxvBXTP5M68asrewuUpn8eZGO8H/tVMeQ/81p+2e+8NX1rXtNQHLG9g8oyPzg0MTuOIJB/mt9cvNmtX4V5sOjzzzm6HcI52et1cu6vUTGX95X6xrzwz/vIP7efWqqgi6K5Pco8J2i3mPo//VSl8neUWAO0m8ThgnOD/V11B8dX6wrHc09vsNQhwfyjbI2qzZkqt1rS+0XUgJECF3VFKsECYAVrrR+QWxNsO2NK7FbUssFS7qDBghRCj1DmZOdW7y8/m9v+0o+7cp95Fj/JTf2j33qqvYpCN8mOUJH50SMTok6/Z1iOS/KEjDaqBn81J1M/ze+upMZH6yv1jWMdXvPrNQXPJF1YdtyVqvLCHQ4r6ShaW7x7yJ76vPIPyVM7RsibU5aHG1KWtJSlKCOgopmTjjFVB/8A2jah4O+m3Niu6+RP81N/avfeqqgrVk8lLFhItiLQ4tTS8ElKAkyrmzN3HJROelS9p2glJIndrVk5XuXbA8f0h9+muQW/aBUTJPd664TydYYLQ7t0AxemKyqILQd5rKhoA27hR27QQaZzAilJgCuhkk2tokVI2XaxABJqsqUZpRWay4lUrFyb22TvNS2ztsZTmK52ypWJ08e2pGzWqBxrLgXedKVtoXMM6Eraou4ekyf3VQ2LeZxNOkW475NZaZpNFv8AOBGczpWmnxgMo/jVca2jESffTxp4KyOmXb21DRbPOZSThOE+BoK3wU5fGtQ6bcR6vRWvOp19VSwJBgJR2kATO8ZUewkpfaF0TfGsaHWoq8obiMKe7IdBtDP1xjVS5I8Mu6nHr6fk05K/nOKf0a5V5elLIsl9IGLmSp0TwFdfPXHYr1prk3+UAOjY/rOepNepHkLX5LFODZVjhKSOaw6REi8rS7hVmYcdjqJzPzzv+rUD5KvzTY/sv2lVZ2Bh3n11AN7Mpy6Ogn/Gd/1a8pW+efd+2e+9VXrVjqivJW0D8q99s996qtRKjuvkSv8A4MEBMc89mT/SbgKvTJcxwRmdT7qpXkPP8lp+2e+8NXxrXtNQg3Y5yD1OsrVX0jwrz/Z5/wA4xle8/V2fOn0V6IZy71frGvPdlH+sg/t6/wBuqio71aOd6MXOsPpca24HZT1M9ytx40a0Hq/WHtrb5xR9b9k1CHNfLtf8xavXY84TlM/k3N/fT/yMc5+C24uxzj2cz+VVTTy9n8RZ/tCfu3KkvIuP5Ka+0e+9VV7AtzAdjNGatFfSPGkWbnSiZbzOio6x407YOHer9Y0iydQd/rNQHlN4nndpg7lyR/bW8q7l5F2SdlNdNQlx04Xf6RW8GuFOq+U2me3025uu++Rj81M/Wd+8VRlDctWSnZz5Li1dJOBu/wDyEbkiuM3iScNPXXauXpP4LtG+8n/qUVxNJrlPJ0hgwJrK0TWVk0MgqaUVbtKAHf41hf411IOFLHGa2lI1NBbVNESQdcajAYgjspxZ+z4OFMwFE4E5U4QmI148JoA1rQfDjSfOIHsoywDhMH0fGdMltRIxka76yB3Z7VjuqSsdsAx9VV9tyM6d2ZcYd5qNGkyeRbN+VI/CMa6+qodVo/dWm7VBxqbS7ixt7RJ34T6cqM3tgsfjF0LLQLl2boUUgmJgxPZUIh7Amm+0n/kXR/Vr/VNVRK3wWI+W90kEWFGAIxtCtYOfNcKq/LnlyvaXMhbCWQ0VEQ4V3rwA1SmMqpiados10Bbig2giRqtQ3oROI4kgdtdzzJHQOTPlTfsllasybK0tLSbgUXVJKgCcSAg499SSPLRaMvM2cP61ev8AcrmybdYUD/Z7Q8d7ryWh4NJJ9NDc5RNJkN2Gyp4rS6+rxdcj0UsU6V/pntIwFlYw/rHP/GuZPrvLUSRKlLUYOV5RVh41tHK59PURZW/q2Oy+m82aTauVlrcEKWgjcGLOn9VsUBbeSvlKf2fZhZ22mVJvLXecKwZWokiEmKlj5b7WIhmy449Zz/yrmmzdu2lhV9ly4rsSfQoEVJjlxb9X0ntZs59BaoP0XYeWu26M2Xf/ADmpn6fGqg3t1xNu8+ARzvOl8Ag3LypJETMdI6zTJ/lVaFgpWWCDr5tZQruUGhUlse2tuhIXYbKuVRI51tR3kqQ4AnUyBhBqSkoq7OtKjKq7RXyWl3yxW8x8nZhBB6rmfH5StK8r9vUQbtmF3H8mvdEYucaiLVZNjOApatPm7g3l11qd151AkcQoTUDtrYTtlCS4EqbWPk3W1BbS4jBKh86PmmDV4ZzasS/Kvl5atoNpafDIShV9PNpUDegpxJWZEKNOOTvlEtliYTZ2eZuJKiL6FFUrUVGSFjU7qpmorFka1bEOgf6YNpDWzb/yStTP9JQf9L+0kiAqzx9kdcfp1Q1j1e0UFYpYg5ZtJItM5uJSTpj5whZ9NTeyeWluszQZYtKm2xJCQlBgqMnrJJzNVpnNX1f2gaMDQpamOWFufPMO2pa2lklSCEQYlcmEg9YA50WRrwqu7G/Lp7FfqqqxOdXLX31xqZOkcAVuY/vrKEG+BrdQoyCQRE4jflQFLxjSkqchRoSnJroQdh6jNLE4kZCO8TUeDhAz3zp76K0RAwx44+uo0CWBgTex0jSiWd2cD4++o0v7hnvpww7rp8T3ipYEg8+kRvoPOgiSfbTZ5w/xoHnBiPdQDpaporD8CmaHcIj47q0KjKPgZyrFDvrbREHs/fRtl7NftP8As7Ljo3pSbv8AjMJ9NChG1ERNCtypaWMSShQEZkwQIGtW3ZnIm1BxAdbbgCS2XAVEcUIUDHfT7b/JxtIS0H2rE6vAqKHXIB+a2tRCUE/SGOeIpYtrnIFqSxnC3vonFDR/T+m5+jknWTgIp+0KUoqJKlEyVKxJPfXTB5Ercoym0WVScSkhTmI0P5M59prQ8iFvHz2D/wAVUfc10uc9rfF0cuMnGlGM86uO0fJ3amrQiyrW0lxyAjpquqmQIUUbxHbFSavI1tAZlgdr3/5qb0a6TWbHOi5uEUgrNX61+Se3Ni8eZM5BLwKlfVESe6qvbuTzzKrrra0KzhQgwcsKbkI0pSxyQ81upn/Nm03QvmXQg4hRbISQcQQo4Gm6tkrGakjtPumpvRpaao8IYVYx8nZlnUoCO9zA+i9UZZ9mmQSQY0/jVysFraZZId2ebaXVgJHShBSMB0QTeVf8K4ympzSR9ClQnQ09SclZuyX7yUALqZ5M7a5hZQvpWZ2EvtHqKTkFkaKTMgiDxFdKsOzWRAXsxizyAqEm0vrHAlN1sHgXJGtMbbZrL00uWdlKFIUkXyhkpJBCXEr84dUCDB6uOVd9x8zZdcFL29ss2Z8tglSCAptf021TBnUggpPFJqKfz7q6ja+ST1q2e1cvOKsqUpZcWCnn0qnnUtyBCUquhJVE3CfnTXMrc2UOFCklK0mFJUCCCNCDlWk7mWmhCh6h6xQVnGjKV6vaKCoZmqZNNdY/VPrFEUcRQWz0j2H1iiKoCQ2QqHkHt/VNTt8wZ041XtnHpp76nUrGtcp5OkTFPnh6ayhKcE5+gVlYNEc8Maaqo77gu4fHfTVSsSa6owGRE8KLxpsg8KOhNUDglUY1ti0kEeqhOExups05jUKS6nxkdd2nZQRupm84eHuoqVmoBxfGZy17hUnYtk3Uhy0uGztqMpSUFT7g3ttYQnS+qB20z2A0V2lhIF484kxjHRN68YkgCJMA4CulbU2azagtxSrM84S0lsMvXXEoDYDhUoiFm/JCQDhuxiO9uMnSkoOS332/BSm+UNnZPyNjCoMhdocKlzoQhEIR2Y9tGtHlIt6wUF0pbJEpRCVQPmpciUg7xjSLbyaZbdU05bG0LCkgI5p5xYvkc2HA2khClSOjNN/wAwReTtCzRF6VpfbF0m6FSWzgVYTXnfV8H11HQrhSRNbN8pq7Oi7Z7HZ21HrLKnFqVxWom8o8STTXaHlN2g8khSmruqQ0CO+9NBY5EuuBRaes7oR1i29N3GMejKTO8U42ryetCgi+WGkAQgFxptMTBKQMVyQcTPDdU3yw8mujpk04tNd3fBX7HyitbIUGrQ42lRkpQSEzJ6qck56RWneUVsV1rXaD/wAVz2Kp6OTJJjzmygyRi+MSkSQIBypwzyKdWkKbtFkWDlFoTJ7JA3VFv8HS+lX9kQbK1vOAO2gpAk33VLVEY4ZkncBT13aDLZHMIU4oH8taIWT9Rk9FA7bx7KRtPYb1mWW30FtXHEEb0kSFDKtI2egc3zilJDhCUFKCu8o4BIIISFcCoVFKTdkdJwowSnOXDx4HKOV1uA6NqdGuBSPQB6KjdobRefXzjzinFkAXlZwMhhU1ZbJZy4GRZ7Y49fuc2oNtKvTGQKoGeJMYGnPKzY/mr6EsWfnmlAlL1111KoKkwUIIF6RlxrqqNVtJ8XPLLW6OPMVd/CK4ovPkTzjxGXXXA3CZAHZSUpumFJuncRB75rrPI/Z/4mV2wKaSVDmSi+w59EgoEYExEiTjpQtt8hELadDC12h6QpCXCkloT0gpwdbCYCtas6LStc5UPUlvXs4OY2VUrSMBiMTl21Jrtq2UBDS1oWSoqukpIQrFKSRqQZPaKf2Dke4q/wA58kU53jgg/pnwwHfFMttbJVZyhznEOtrVgtGV4YlJzg9++vLsklex9xamjOfTck34IZ9S1ZqUe0k+s0EMUd1eNNy7jhieFYTkzvONKBL2blTbW0hKLU8EgQBfJAG4TNRnKDaT1qh190uOJ6OKQDcIzlIxxwM7xQVhScFJIOcEEH00UMJKekrpLSSlG9A6xJ04dlemi5bj4uvjQ6TeGRE9+HtFYi5eF7BOMnHup0Wkzj7aYugTXtPztjSSL6ox6JjxFGWMfXTdsi+fq08abBGp8d1BYJs38ondBnwNTKRUTYm4cSRx37jUtenKuc8m4iFL41lCWoTWqhojydOFDZQMaWuhk1swLkaVtowe6gKXjW0uzVA7GOvcaFdlUCY+MqS65gAN1Es64xA0jiP30A6gAfGNaQ4MRQXHBNAWoTh31AWDYO1GWlKQsL+WHN32ylJCSYUkFWV4wCdw41b9miy3g3Y2nEvuHmyHFBUo6yhM3RN0DdjXMOfuqQSSEmUquxeuk4gFQIB41ZmrWUOJWCLySJhQVuKeknCbpHYZry1rx9yPtaHZVi6Ldnbj/SJTtG0IeW4pRDnPJUuSCQtLjqDOeI5xY9O6k2fbbqQkTgkWXCBEWd1QSDhlOMamrVaV2B9RW41dWrFSpcTKpvXoReEzuAGOQyoLvJ+wLBuu3SQcnRh0woYLbGRkd9dlWg+58+p6dqY5gxpyb2s4takE4cxbb2HW5xYWoqOuQ8KJadtFu0CUpVdtDDnSTe6LdnAQnMYA4gYY09smy7MypRaeTK0uIlTgUEJcicETgIzO/WnG1+S6HFIWlxKVBLYXcWhxC1NyCrFQUgqTdEXYF2cZqKpHfkstNVVBJxeSttcoVhtEQCmz2tN67JvPr6a+t1iDE6bjQtobdWpDqAEi9ZLPZwQnqNoWlRSk3sAopx3zlT93kukQkvaOJwQo9Yynqg5a0Ucj7ySedUJSgTzRzScT0ymQd2nGt9SPk8/41Zc7H9Fl2JtZFvsjzLqUINl5vmzEJS0pKURngAsanJVQFoZfs7iuZUU7ykpUhW4wZCuBImnVudZsrC2WAQt0guklKlKgQAopJCUiTCZnEk1Wb9eCu053gfp/SqMo6fbWXHZNE+vbu0TgbW7/AI0io607StMyq1OzwfUPQlVQzrlNHl1Y733N1fxoLiki48n9lWq2uc2HXSkSVrUtakoEayYJOQGZ7K6btHaNlsiGrMwuLQmEtJbMkFRE87GEHrGccJriWxNsPtIcbbcW2lcXgMLwGGeYz0NPbHaObQ89OKG1XT/WOfJpPbio91dY3i9uWzwVlCrTdbhRjhLz8muV+2zaVrZQsiztKjD+cckytW8lRMeOtR/Jt/5O0szKbqXQNAptQBIGhhRHdUnyOYuc05cvJW6WbxAupUplSiZOS4uwdBeOdIUygW10NgBBs8GDeEqbRJnWSqZr1SXtaPiUZNVYy+RxZLO0hKXHiCVSUpJwiYBIGJJjKlubfCfySfCED0Y1AFoyRGtEbZM+iM88K8KR+lnJPmTMtTynV3iZUoganhrR9mWIPWplJVcDqy0k6hJBQggnQkAdtOG2eaQpRGISTxxwGGmJFOtivOX7GhxJCEuWYtqIzSp8KSBGYKr/AEj9GvVSi0uT4uvrxm0ovBZUeSgK/nnPEe6lL8j6f6V30e6uytWEDOKW7ZRH7zW1fyfPucQ/0ToSfyrno91GY8lidHnP+X3V1J+yY61tpgDfTnyLnI+UHINNkZU9zq1FJTgQI6SgndxqrCupeUdfyCkyc0YHLBY91crWqobjgEqsrSl8ayqUhvOsIikeccKHdrAitnMUp6dD41oO8Kzmq3zdAYH+A8aULUdw9NJuVvm6FNrtBOgHjSedPDwrd2t3BQB+ZKkJV+krIbo3dtO7S4pTN3p3mxIIu3QgZzdSFTJzUTpWbPtTdzm3CUwolKgJHSiQoZ4Xc+NT/J7mm7QguPs8ysKbcN/C44hSVSlQBwMHLOK4bpKVrcH0o0ac6O9StJLBU9l29d670lzpiThjhVu5P8sLKwgt2iwptAJJCj0VpnMEkGR6qp1tsJYXCu1BmL6fmqB3EQZFDDiuPcs+2ujpxbvY8i1lZU+nu4OhWvlbspfVsamTqev3ABSYGeOe4Uez7f2KUAONvX9VIvITnom+Yrm/Oq/T8QfXSVOH9L/Ck06cfAWrqrEn9svu2ttbPupFjU9eJ6Rcc6KQNAk4kntwiq/a9sRkQtR4z4moAODh3tj2UZp8gG4EZQegLwHC9Mdorm9NBu9j1R9W1EYbE/33HLu3F5XU+JordrKkSRE1DsNKcWEpEqUYA7auWy+TK3pDIUtKcFLwS2nipZwFJ0Y29qLp/UKu59SbasQRVQnSDplGEK6XZGlWq27KsLSFIW8p54iAGPyaDvLi+v3Dvqsrs0xJywxKjh41mO2L5Z2q9etG0I8fQjZw6Zz6p0I3b6lrW5FljVx9I7m0Xj6VCnew9iNpTzzwwUIbSMCRPScJHzcCkakqn5tRvKO0thaG2wUpReVAJOKyB1jjkK3GO6e4806nT0/QebhHdtPsstsoPya087Ch0SvnXEpUJyNwFMjeRpTxkJF1oEFZZK3XcTeW4UKKIOiEpSkcSqmx2q6uzsMhLEMpCkPKBS40HFLWpN4m6ZIUcQetvE1JWuxFjmQpktvls8501OXpuFEJPUVBlQGGI7K7NXPBBtSuhuGkpxJKvQKGraAT1YH1c92dOzsB5fScNxJxg4q70g4d9Pn+T1m83cSA6t8tktqJupC4kQlJgzEYznWErYR6Kk7/AMpXZVdo7QluAcSrfj0dTU5yLaWp1sF+CUoU2noOAgLQFNqCsW1RBEaXspqiwQccxhBzB+Jq9+S26u1NAonmSXSrOLpF3xN0dk1s8p6BYUucbypO8e2nLqcPnd6SR4iaZ2O3zmR3wD4U8cfkYYeFQEBa2ATgoHswobdjn6R7JNO7Takg4qx7BRbKpCsZx7qFOc8vmLrZxOacwR84b654TXTPKc3DKiCCLyMvrDSuYVk6LBhNZWiqsqgi0t9tZd7afFg0jmd9aMDSO2s5rhTzzbd6qUmxk0Ay5sdtZd4GpNNi+MaQ5YqAjlDtrO41IiyUlTMDSoUYhFNbQCk4HA09caNNHp4VUyMdbP5R2lhNxDko+gtKXEdwWDHdFO/87CevZLGvtYAP/IRUAWzSSiqYLIOUFnI6WzrP/cW8g+hVZ+E7Cf8A0Cx9S2LH6zaqrqaUKAsId2cc2bajgH2VfrNA0hx7Z4xS3bFRkFOspHilsmoIr3UgqJoCbe2ykAhllLM4FRWpxwg5i+rqz+iBUw7y551ttq0WdK2203UpadcYTgMylMpJnGYmqWBWzUaTRuE5Qd1kn/w2yMrOO9xZ9gojHKi4q8mzsYfSCljvBONVqaUF1hUYLsemWvryVtxLWjlA6tRUoyTn7ANwAwA0qNWsrJJIk8YoKjWproeRybd2W7Y/MrZZQu6QHQp1CiQVDnEtgpIwhKCqcZ6RpVt2qohlKiSptu7I+cm+q7J16ISAdwFVux2y6kpOsYjMAEKKRwJA8KO9ay4tSzEqJMDIToBuGA7qhUTI22rIFWOYnA9oNK/CzkEAkEiAZ8PCoVCqdsnh6BUNZFsWIEm8kGcTJxPEnOrNyWY5l4KQCkHBQbMFQ3ce+omy2mMMu2DVq5NvILiZIGIx17ooa4Lzse3Oqc/IO83pevlW7CBB31M2i3hPzFJO4g4d8CgtsgdV4HDK8D76x3m7vSInQT8euhi6Ipy1SZn476k7BtOBmk9oST4Z1XX7WidM6dNWhIE4cd/oyoUifKRbOcYKSB128kgZKmuZLwroHLi1BTBAgG+jUycdxrnqjUKjU9tZSKyhQpdO40kLP0TRYI/gK0mFY48Mo9FUybRaN1LbVOYn44UgtcCT8a0pAVQCiqMJjtmPTQFuY9Y+GFEWMccPZQnLOTxGmNAbvg6mkKRNEasxGnx7KMlBoBktk0ycsx4VMFpR0oDtiJ4UIRRYI0NDW321LnZ6x870UBViVwPjVBHJaFE83G710+bsZBxSI7fTRRZZ09lLksRnmwrXmlSSrGdR6vXW2mzx+O+gsRfmu/CkmyGpvzbfQlWcA4x8d1C2Ifzc0pNln+FSqrNgMvH99a5gRlHiaCxFmxxoPTSDYzUipO4+NaSk9tCWGCLKd00dDH6NSKANQaUGdw76FSGgYjQiiJYj+FP/ADc/BonmZqFG1nRV05E2UF9JMm7BxA9AIg1XbHYzMHKrlyduNqBhKt4MhXcCIPZxq3B0hy1ADBKSMOqADnEiAR3VC7SWSDnHEY+j103tO1QmUtrSjDEFDaZ4hV0TuqK2htFwjrA7sAPVUM2Ii2HpGIGOuPrpaEOJycEcB7Zphanccx3TT2xoSqOmJgYHjuw9lRs0iN5WKVzRBx6SccRl7KqBNW7lVZ4bBvhQvAQJEZ6VU1VEUHWUkmsqgmA3xpaW054n47KAVKxJHgQawvYZH0e+qQOUp1PdWi2M4PdTNLis475n204TaCRinwI9pqFFhobvGKOGDmBQQ7jN0+IpQfP0CeF4UBtLBzKSfZQ+ajIa0Y2pw6EdkH99IS4uekCR4eygNqTvEURDR3Vt17WCP7w91NBalA+8poQeFJyig3Ezr4YVgtSiNPH2ChqcVuHiaAXdA+b6K2iypicRPd4iMaU2tXCjBazp4kUKYbMgEQonfun0Vj6W4mD4UNxxQOAA/vT7KA66obu4+8UIAtETqR2GmzjeEj3U6L3AeJ91EMxEAfHZNAR/N7/eKIG07xj3eynDjRygcMSJpBYM4+s+2hRLTAOvhl2mkFkD5wz3DGpBizdh9HtzzorjBgT4fBzoQiVJpaGicsafqsUfROuXr3VsWZUxeQJxGKh6hVA3awzFOAeytOoUjNSMcsCfGcq2EE6J+NwoUcMHUR66nbFtBaRHOEjK6eqeBERPHPE1VlMq0Mdoj20tPPJyV4CfRUBabSlazgopTxVeHcFZdxpg7Y1nDE9+o0x14a1Ft7WdBhXZlj6aO9tAKGeMfOAI/fQCSlQOZHAgz2EZ0dlcCLoJ1IkR4imotK9CkzkABR3W1FMkkb5KceyMajA322oFsACMRr291V5fbUhayYxJOmkdtR6zRACVVusKuysqgtS7MeAHCm5sGorKyslBOMkaUNTEVlZVQE5caxG+t1lUBgSBr4itlwbvVWVlCCebmtJbM6H441lZQCijCAKxKD3VlZQCimImiNAcfGtVlCmpnf4++grGExPbWVlCGkI8fiMaK0QcMRxmR4VlZQC1WK91PYNK2qxqwwnjPjhWqygMQYETGOOs0dDoABEqB3xhiMqysoBRfQcQiCM8dKC8zJxw75x4zWVlABNk1vT2jKnLbhThMn39o9VbrKAG6kziI+O3hRkIGfp9vdWqygHybJeGJwAxBM5YxiIpq7spMm8kjdjgYAJy7RW6ygI+0IQgmBJ7x6abc/v99brKAauvXopo4a1WUAA1qsrKA//Z");
        // $query = "UPDATE sample  SET aa ='$binary' where aaa=1  ";

        $a = base64_decode($url);
        $b = array();
        foreach (str_split($a) as $c) {
            $b[] = sprintf("%08b", ord($c));
        }
        $ra  = implode(' ', $b);
        $Rff = bindec($ra);

        $data = base64_decode($url);
        $im   = imagecreatefromstring($data);
        header('Content-Type: image/jpeg');
        imagejpeg($im);
        imagedestroy($im);

        $s = base64_encode($ra);
        // print_r($b);

        $statement = $this->connect->prepare($query);
        $ten       = $statement->execute();
        /**
         * @var string $query has query to update the user profile pic
         */
        $query     = "UPDATE registration  SET profilepic ='$url'  where email='$email' ";
        $statement = $this->connect->prepare($query);
        if ($statement->execute()) {

            $ref = new LabelController();
            $ref->fetchImage();
        }

    }
}
