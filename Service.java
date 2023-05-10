/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.mycompany.entities;

/**
 *
 * @author zeus
 */
public class Service {
    /*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

            private Long id,id_client,client_phone,ouvrier_id;

    private String servicename,location;

    public Service() {
    }

    public Service(Long id, Long id_client, Long client_phone, Long ouvrier_id, String servicename, String location) {
        this.id = id;
        this.id_client = id_client;
        this.client_phone = client_phone;
        this.ouvrier_id = ouvrier_id;
        this.servicename = servicename;
        this.location = location;
    }

    public Service(Long id_client, Long client_phone, Long ouvrier_id, String servicename, String location) {
        this.id_client = id_client;
        this.client_phone = client_phone;
        this.ouvrier_id = ouvrier_id;
        this.servicename = servicename;
        this.location = location;
    }

    public Long getId() {
        return id;
    }

    public void setId(Long id) {
        this.id = id;
    }

    public Long getId_client() {
        return id_client;
    }

    public void setId_client(Long id_client) {
        this.id_client = id_client;
    }

    public Long getClient_phone() {
        return client_phone;
    }

    public void setClient_phone(Long client_phone) {
        this.client_phone = client_phone;
    }

    public Long getOuvrier_id() {
        return ouvrier_id;
    }

    public void setOuvrier_id(Long ouvrier_id) {
        this.ouvrier_id = ouvrier_id;
    }

    public String getServicename() {
        return servicename;
    }

    public void setServicename(String servicename) {
        this.servicename = servicename;
    }

    public String getLocation() {
        return location;
    }

    public void setLocation(String location) {
        this.location = location;
    }
    
    
}


