import json

def handle(req):
    """handle a request to the function
    Args:
        req (str): request body
    """

    json_req = json.loads(req)
    try:
        z_sid = json_req["sid"]
        z_body = json_req["body"]
        file_name = "solution_%s.py" % z_sid

        f = open(file_name, "w")
        f.write(z_body)
        f.close()

        return file_name
    except Exception as e:
        print("%s: %s" % (req, str(e)))
        return None
