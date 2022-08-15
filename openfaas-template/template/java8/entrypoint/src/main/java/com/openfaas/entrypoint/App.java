// Copyright (c) OpenFaaS Author(s) 2018. All rights reserved.
// Licensed under the MIT license. See LICENSE file in the project root for full license information.

package com.openfaas.entrypoint;

import com.sun.net.httpserver.HttpExchange;
import com.sun.net.httpserver.HttpHandler;
import com.sun.net.httpserver.HttpServer;
import java.net.InetSocketAddress;
import java.util.Arrays;
import java.util.HashMap;
import java.util.Map;
import com.sun.net.httpserver.Headers;

import com.openfaas.model.*;
import java.io.*;

public class App {

    public static void main(String[] args) throws Exception {
        int port = 8082;

        IHandler handler = new com.openfaas.function.Handler();

        HttpServer server = HttpServer.create(new InetSocketAddress(port), 0);
        InvokeHandler invokeHandler = new InvokeHandler(handler);

        server.createContext("/", invokeHandler);
        server.setExecutor(null); // creates a default executor
        server.start();
    }

    static class InvokeHandler implements HttpHandler {
        IHandler handler;

        private InvokeHandler(IHandler handler) {
            this.handler = handler;
        }

        @Override
        public void handle(HttpExchange t) throws IOException {
            String requestBody = "";
            String method = t.getRequestMethod();

            if (method.equalsIgnoreCase("POST")) {
                InputStream inputStream = t.getRequestBody();
                ByteArrayOutputStream result = new ByteArrayOutputStream();
                byte[] buffer = new byte[1024];
                int length;
                while ((length = inputStream.read(buffer)) != -1) {
                    result.write(buffer, 0, length);
                }
                // StandardCharsets.UTF_8.name() > JDK 7
                requestBody = result.toString("UTF-8");
	        }
            
            // System.out.println(requestBody);
            Headers reqHeaders = t.getRequestHeaders();
            Map<String, String> reqHeadersMap = new HashMap<String, String>();

            for (Map.Entry<String, java.util.List<String>> header : reqHeaders.entrySet()) {
                java.util.List<String> headerValues = header.getValue();
                if(headerValues.size() > 0) {
                    reqHeadersMap.put(header.getKey(), headerValues.get(0));
                }
            }

            // for(Map.Entry<String, String> entry : reqHeadersMap.entrySet()) {
            //     System.out.println("Req header " + entry.getKey() + " " + entry.getValue());
            // }

            IRequest req = new Request(requestBody, reqHeadersMap,t.getRequestURI().getRawQuery(), t.getRequestURI().getPath());
            
            IResponse res = this.handler.Handle(req);

            String response = res.getBody();
            byte[] bytesOut = response.getBytes("UTF-8");

            Headers responseHeaders = t.getResponseHeaders();
            String contentType = res.getContentType();
            if(contentType.length() > 0) {
                responseHeaders.set("Content-Type", contentType);
            }

            for(Map.Entry<String, String> entry : res.getHeaders().entrySet()) {
                responseHeaders.set(entry.getKey(), entry.getValue());
            }
            
            byte[] data = {};
            OutputStream os = t.getResponseBody();

            try (FileOutputStream fos = new FileOutputStream("/home/app/Solution.java")) {
                fos.write(bytesOut);
                byte[] bytes = new byte[2048];
                int len;
                Process process1 = Runtime.getRuntime().exec("javac /home/app/Solution.java");
                int exitVal = process1.waitFor();
                if (exitVal != 0) {
                    System.out.println("error1");
                    InputStream in = process1.getErrorStream();
                    while ((len = in.read(bytes)) != -1) {
                        data= Arrays.copyOf(bytes, len);
                    }
                }
                else {
                    System.out.println("Save file success!");
                    Process process = Runtime.getRuntime().exec("java -cp /home/app/. Solution");
                    exitVal = process.waitFor();
                    if (exitVal == 0) {
                        System.out.println("Success!");
                        
                        InputStream in = process.getInputStream();
                        while ((len = in.read(bytes)) != -1) {
                            data= Arrays.copyOf(bytes, len);
                        }
                    } else {
                        //abnormal...
                        System.out.println("error");
                    }
                }
            } catch (IOException e) {
                System.out.println(e.getMessage());
            } catch (InterruptedException e) {
                System.out.println(e.getMessage());
            }

            t.sendResponseHeaders(res.getStatusCode(), data.length);
            os.write(data);
            os.close();

            System.out.println("Request / " + Integer.toString(data.length) +" bytes written.");
        }
    }

}
