/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

package autoparser.data;

import java.util.List;

/**
 *
 * @author swat
 */
public class AutoSalon 
{
    protected String          name;    
    
    protected List<Integer>   brandsIds;
    protected List<Integer>   servicesIds;
    protected Integer         salesChainId;
    
    protected boolean         official = false;
    
    protected String          description;
    
    protected String          siteUrl;
    protected String          sitePresentation;

    protected Address         address;
    
    protected List<String>    workHours;

    public AutoSalon() {}

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public List<Integer> getBrandsIds() {
        return brandsIds;
    }

    public void setBrandsIds(List<Integer> brandsIds) {
        this.brandsIds = brandsIds;
    }

    public List<Integer> getServicesIds() {
        return servicesIds;
    }

    public void setServicesIds(List<Integer> servicesIds) {
        this.servicesIds = servicesIds;
    }

    public Integer getSalesChainId() {
        return salesChainId;
    }

    public void setSalesChainId(Integer salesChainId) {
        this.salesChainId = salesChainId;
    }

    public boolean isOfficial() {
        return official;
    }

    public void setOfficial(boolean official) {
        this.official = official;
    }

    public String getDescription() {
        return description;
    }

    public void setDescription(String description) {
        this.description = description;
    }

    public String getSiteUrl() {
        return siteUrl;
    }

    public void setSiteUrl(String siteUrl) {
        this.siteUrl = siteUrl;
    }

    public String getSitePresentation() {
        return sitePresentation;
    }

    public void setSitePresentation(String sitePresentation) {
        this.sitePresentation = sitePresentation;
    }

    public Address getAddress() {
        return address;
    }

    public void setAddress(Address address) {
        this.address = address;
    }

    public List<String> getWorkHours() {
        return workHours;
    }

    public void setWorkHours(List<String> workHours) {
        this.workHours = workHours;
    }
    
    
    
    
    
    
    
    
        
}
