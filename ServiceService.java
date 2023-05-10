package com.mycompany.services;

import com.codename1.io.CharArrayReader;
import com.codename1.io.ConnectionRequest;
import com.codename1.io.JSONParser;
import com.codename1.io.NetworkEvent;
import com.codename1.io.NetworkManager;
import com.codename1.ui.events.ActionListener;
import com.mycompany.entities.Service;
import com.mycompany.utils.Statics;
import java.io.IOException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.List;
import java.util.Map;
public class ServiceService {
    
    //singleton 
    public static ServiceService instance = null ;
    
    public static boolean resultOk = true;

    //initilisation connection request 
    private ConnectionRequest req;
    
    
    public static ServiceService getInstance() {
        if(instance == null )
            instance = new ServiceService();
        return instance ;
    }
    
    
    
    public ServiceService() {
        req = new ConnectionRequest();
        
    }
    
    
    //ajout 
    public void ajoutService(Service service) {
        
        String url =Statics.BASE_URL+"/newser?idc="+service.getId_client()+"&ido="+service.getOuvrier_id()+"&loc="+service.getLocation()+"&ph="+service.getClient_phone()+"&ser="+service.getServicename(); // aa sorry n3adi getId lyheya mech ta3 user ta3 reclamation
        
        req.setUrl(url);
        req.addResponseListener((e) -> {
            
            String str = new String(req.getResponseData());//Reponse json hethi lyrinaha fi navigateur 9bila
            System.out.println("data == "+str);
        });
        
        NetworkManager.getInstance().addToQueueAndWait(req);//execution ta3 request sinon yet3ada chy dima nal9awha
        
    }}