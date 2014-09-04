/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

package com.ukrautoportal.autouaparser.data;

import java.io.Serializable;

/**
 *
 * @author swat
 */
public class AbstractPoint implements Serializable
{
    protected String          nameEn;
    protected String          name;    
    protected Address         address;

    public AbstractPoint() {}
    

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public Address getAddress() {
        return address;
    }

    public void setAddress(Address address) {
        this.address = address;
    }

    public String getNameEn() {
        return nameEn;
    }

    public void setNameEn(String nameEn) {
        this.nameEn = nameEn;
    }

    
}
