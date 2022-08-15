package com.openfaas.function;

import com.openfaas.model.IHandler;
import com.openfaas.model.IResponse;
import com.openfaas.model.IRequest;
import com.openfaas.model.Response;
import com.google.gson.*;

public class Handler implements com.openfaas.model.IHandler {

    public IResponse Handle(IRequest req) {
        Response res = new Response();
	    

        Gson gson = new Gson();
        RequestBody requestBody = gson.fromJson(req.getBody(), RequestBody.class);

        res.setBody(requestBody.getBody());
	    return res;
    }

    class RequestBody {
        private String body;
        private String sid;

        public String getBody() {return body;}
        public void setBody(String body) {this.body = body;}

        public String getSid() {return sid;}
        public void setSid(String sid) { this.sid = sid;}
    }
}
